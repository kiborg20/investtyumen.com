<?php
declare(strict_types=1);

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;
use Tyumip\Main\Helper\Helper;
use Tyumip\Main\Model\IconDirectoryTable;

class CreativeMenu extends \CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {
        if (!Loader::includeModule('iblock')) {
            throw new LogicException('Iblock module not found');
        }

        if (!isset($params['CODE'])) {
            throw new Exception('Section code params, required');
        }

        if (!isset($params['MAX_DEPTH_LEVEL'])) {
            $params['MAX_DEPTH_LEVEL'] = 1;
        }

        return parent::onPrepareComponentParams($params);
    }

    /**
     * Метод генерирует цепочку из элементов подсекций
     * @param array $aSection
     * @param array $aSections
     *
     * @return array
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function getNavItems(array $aSection, array $aSections): array
    {
        $aNavItems = [];
        $iCurDepthLevel = 1;
        $sDepthUrl = $aSection['CODE'];
        $aLastDepth = ['NAME' => $aSection['NAME'], 'CODE' => $aSection['CODE']];
        $aNavItems[$iCurDepthLevel] = [];

        $iMaxDepthLevel = $this->arParams['MAX_DEPTH_LEVEL'];
        foreach ($aSections as $aSectionItem)
        {
            if ($aSectionItem['DEPTH_LEVEL'] > $iMaxDepthLevel) {
                continue;
            }

            if ($iCurDepthLevel < $aSectionItem['DEPTH_LEVEL'])
            {
                $iCurDepthLevel = $aSectionItem['DEPTH_LEVEL'];
                $aLastDepth['CODE'] = $aSectionItem['CODE'];
                $aLastDepth['NAME'] = $aSectionItem['NAME'];
                $sDepthUrl .= '/' . $aSectionItem['CODE'];
            }

            if ($iCurDepthLevel == $aSectionItem['DEPTH_LEVEL'] && $aLastDepth != $aSectionItem['CODE']) {
                $sDepthUrl = str_replace($aLastDepth['CODE'], '', $sDepthUrl);
                $sDepthUrl .= $aSectionItem['CODE'];
                $aLastDepth['CODE'] = $aSectionItem['CODE'];
                $aLastDepth['NAME'] = $aSectionItem['NAME'];
            }

            $aItems = Helper::getElementsInSection($aSectionItem['ID']);

            foreach ($aItems as $aItem)
            {
                $aProperties = Helper::getIBlockProperties($aItem['ID']);

                $sUrl = $sDepthUrl . '/' . $aItem['CODE'] . '/';
                $aItem = [
                    'URL' => $sUrl,
                    'NAME' => $aItem['NAME'],
                    'ICON' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($aProperties['icon']['PROPERTY_VALUE'])) ?? '',
                    'DESCRIPTION' => $aItem['PREVIEW_TEXT'],
                    'DEPTH_LEVEL' => $iCurDepthLevel,
                    'PARENT_NAME' => $aLastDepth['NAME'],
                    'PARENT_CODE' => $aLastDepth['CODE']
                ];

                $this->insertDepthItem($aItem, $aNavItems, $iCurDepthLevel);
            }
        }

        $aNavItems['MAX_DEPTH_LEVEL'] = $iMaxDepthLevel;
        return $aNavItems;
    }

    /**
     * Метод вносит элемент в нав. сетку по уровню вложения
     * @param $aItem
     * @param $aNav
     * @param $iDepth
     *
     * @return void
     */
    protected function insertDepthItem($aItem, &$aNav, $iDepth): void
    {
        $curNav = &$aNav[1];
        for ($i = 2; $i <= $iDepth; $i++)
        {
            if (!isset($curNav['SECTIONS'][$aItem['PARENT_CODE']])) {
                $curNav['SECTIONS'][$aItem['PARENT_CODE']] = [];
            }

            $curNav = &$curNav['SECTIONS'][$aItem['PARENT_CODE']];
        }

        if (!isset($curNav['DEPTH'])) {
            $curNav['DEPTH'] = $aItem['PARENT_NAME'];
        }

        $curNav['ITEMS'][] = $aItem;
    }

    public function executeComponent()
    {
        $aSection = Helper::getSection($this->arParams['CODE'], $this->arParams['IBLOCK_ID']);
        $aSections = Helper::getSections($aSection);

        $aNavItems = $this->getNavItems($aSection, $aSections);

        $this->arResult['PAGE_TAG'] = $aSection['UF_HEADER_NAME'];
        $this->arResult['NAV_ITEMS'] = $aNavItems;
        $this->includeComponentTemplate();
    }
}
