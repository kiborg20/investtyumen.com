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
        $sElement = $this->arParams['ELEMENT_CODE'];
        $iBlock = $this->arParams['IBLOCK'];
        $iBlockType = $this->arParams['IBLOCK_TYPE'];

        $filter = [
            '=ACTIVE' => 'Y',
            '=IBLOCK.CODE' => $iBlock,
        ];
        if($sElement) $filter['=CODE'] = $sElement;

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
                    if ($prop['USER_TYPE'] == 'HTML') {
                        $prop['PROPERTY_VALUE'] = unserialize($prop['PROPERTY_VALUE']);
                    }

                    if ($prop['PROPERTY_NAME'] == 'INVESTMNET_FILE') {
                        $prop['PROPERTY_VALUE'] = CFile::GetPath($prop['PROPERTY_VALUE']);
                    } elseif ($prop['PROPERTY_TYPE'] == 'F') {
                        $prop['PROPERTY_VALUE'] = CFile::ResizeImageGet($prop['PROPERTY_VALUE'], array('width'=>666, 'height'=>582), BX_RESIZE_IMAGE_EXACT, true)['src'];
                    }

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
