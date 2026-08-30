<?php
declare(strict_types=1);

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;
use Tyumip\Main\Helper\Helper;
use Tyumip\Main\Model\IconDirectoryTable;

class Achievements extends \CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {
        if (!Loader::includeModule('iblock')) {
            throw new LogicException('Iblock module not found');
        }
        if(!$params['IBLOCK_ID'] && $params['IBLOCK_CODE']) {
            $params['IBLOCK_ID'] = $this->getIblockId($params['IBLOCK_CODE']);
        }

        if(!$params['ELEMENT_ID'] && $params['ELEMENT_CODE']) {
            $oElementResult = ElementTable::getList(
                [
                    'filter' => [
                        '=CODE' => $params['ELEMENT_CODE'],
                        '=IBLOCK_SECTION.CODE' => $params['SECTION_CODE']
                    ],
                ]
            );

            if(is_array($params['ELEMENT_CODE'])) {
                while ($aElement = $oElementResult->fetch())
                {
                    $params['ELEMENT_ID'][$aElement['CODE']] = $aElement['ID'];
                }
            } else {
                $params['ELEMENT_ID'] = $oElementResult->fetch()['ID'];
            }
        }

        return parent::onPrepareComponentParams($params);
    }

    public function executeComponent()
    {
        if (empty($this->arParams['ELEMENT_ID'])) {
            return;
        }

        if(is_array($this->arParams['ELEMENT_ID']))
        {
            foreach ($this->arParams['ELEMENT_ID'] as $item) {
                $this->arResult['ITEMS'][$item] = $this->getElementProperty($item);
            }
        } else {
            $this->arResult['ITEMS'][$this->arParams['ELEMENT_ID']] = $this->getElementProperty($this->arParams['ELEMENT_ID']);
        }

        $this->includeComponentTemplate();
    }

    protected function getElementProperty($elmentId)
    {
        $dbProperty = \CIBlockElement::getProperty(
            $this->arParams['IBLOCK_ID'],
            $elmentId,
            'sort',
            'asc',
        );

        while ($arProperty = $dbProperty->GetNext()) {
            if ($arProperty['USER_TYPE'] === 'directory' && isset($arProperty['VALUE'])) {
                $value = Helper::getIconsParams($arProperty['VALUE']);
            } else {
                $value = $arProperty['VALUE'] ?? '';
            }

            $property[$arProperty['CODE']] = $value;
        }

        return $property;
    }

    protected function getIblockId($iBlockCode): int
    {
        return (int) IblockTable::getRow([
            'filter' => [
                '=CODE' => $iBlockCode
            ],
            'select' => ['ID'],
        ])['ID'];
    }
}
