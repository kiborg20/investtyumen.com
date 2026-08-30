<?php

declare(strict_types=1);

use Bitrix\Iblock\ElementTable;

/*
 * Компонент собирает список элементов без учета разделов
 */
class MainList extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        if (empty($arParams['IBLOCK']))
        {
            throw new \RuntimeException('Not Found');
        }

        return parent::onPrepareComponentParams($arParams);
    }

    public function executeComponent()
    {
        $sSection = $this->arParams['SECTION'];
        $iBlock = $this->arParams['IBLOCK'];
        $iBlockType = $this->arParams['IBLOCK_TYPE'];

        $filter = [
            '=ACTIVE' => 'Y',
            '=IBLOCK.CODE' => $iBlock,
        ];
        if($sSection) $filter['=IBLOCK_SECTION.CODE'] = $sSection;

        $aItem = ElementTable::getList(
            [
                'order' =>
                    [
                        'SORT' => 'ASC',
                        'ID' => 'ASC',
                    ],
                'filter' => $filter + (isset($iBlockType) ? ['=IBLOCK.IBLOCK_TYPE_ID' => $iBlockType] : [])
            ]
        )->fetchAll();

        foreach ($aItem as $code=>$item)
        {
            if($item['PREVIEW_PICTURE']) {
                $aItem[$code]['PREVIEW_PICTURE'] = CFile::GetPath($item['PREVIEW_PICTURE']);
            }
            if($this->arParams['PROPERTIES_CODE']) {
                $props = \Tyumip\Main\Helper\Helper::getIBlockProperties($item['ID']);
                foreach ($props as $prop) {

                    if (in_array($prop['PROPERTY_NAME'], $this->arParams['PROPERTIES_CODE'])) {
                        $aItem[$code][$prop['PROPERTY_NAME']] = $prop['PROPERTY_VALUE'];
                    }
                }

            }
        }

        $this->arResult['ITEMS'] = $aItem;
        $this->includeComponentTemplate();
    }
}
