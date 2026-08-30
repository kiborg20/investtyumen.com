<?php

declare(strict_types=1);

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Tyumip\Main\Helper\Helper;

class MainFullProperties extends CBitrixComponent
{
    private const IBLOCK_TYPE = 'sferyrosta';

    public function onPrepareComponentParams($arParams)
    {
        if (
            empty($arParams['IBLOCK']) && !isset($arParams['IS_EMPTY'])
        ) {
            throw new \RuntimeException('Not Found');
        }
        return parent::onPrepareComponentParams($arParams);
    }

    public function executeComponent()
    {
        if (isset($this->arParams['IS_EMPTY'])) {
            $this->includeComponentTemplate();
            return;
        }

        $section = $this->arParams['SECTION'];
        $iBlock = $this->arParams['IBLOCK'];
        $sCode = $this->arParams['ELEMENT_CODE'];
        $sIblockType = $this->arParams['IBLOCK_TYPE'];
        $elementCount = $this->arParams['ELEMENT_COUNT'];

        if (!isset($sIblockType)) {
            $sIblockType = self::IBLOCK_TYPE;
        }

        $sect = SectionTable::getRow([
            'select' => ['*'],
            'filter' => [
                '=CODE' => $section,
                '=IBLOCK.CODE' => $iBlock,
                ],
        ]);
        $this->arResult['SECTION'] = $sect;
        $this->arResult['SECTION']['PICTURE'] = CFile::GetPath($sect['PICTURE']);

        $elements = ElementTable::getList([
            'select' =>
                [
                    '*',
                ],
            'order' =>
                [
                    'SORT' => 'ASC',
                    'ID' => 'ASC',
                ],
            'filter' => [
                    '=IBLOCK.IBLOCK_TYPE_ID' => $sIblockType,
                    '=IBLOCK.CODE' => $iBlock,
                    '=IBLOCK_SECTION.CODE' => $section,
                    '=ACTIVE' => 'Y',
                ] + ($sCode != '' ? ['=CODE' => $sCode] : []),
            'limit' => $elementCount ?: 10000,
        ])->fetchAll();

        $this->arResult['ITEMS'] = [];

        foreach ($elements as $index => $element) {
            if($element['PREVIEW_PICTURE']) {
                $elements[$index]['PREVIEW_PICTURE'] = CFile::GetPath($element['PREVIEW_PICTURE']);
            }
            if($element['DETAIL_PICTURE']) {
                $elements[$index]['DETAIL_PICTURE'] = CFile::GetPath($element['DETAIL_PICTURE']);
            }
            $props = $this->getIBlockProperties($element['ID'], $element['IBLOCK_ID']);
            $elements[$index]['PROP'] = $props;
        }

        $this->arResult['ITEMS'] = $elements;

        $this->includeComponentTemplate();
    }

    protected function getIBlockProperties($element_id, $iblock_id )
    {
        $dbProperty = \CIBlockElement::getProperty(
            $iblock_id,
            $element_id,
            'sort',
            'asc',
        );
        $dir = realpath(__DIR__ . '/../../web');
        while ($arProperty = $dbProperty->GetNext()) {
            $value = '';
            if ($arProperty['PROPERTY_TYPE'] === 'F') {
                if ($arProperty['VALUE']) {
                    $fileInfo = (CFile::GetByID($arProperty['VALUE']))->arResult;
                    $fileInfo = reset($fileInfo);
                    $value = [
                        'path' => $dir . CFile::GetPath($arProperty['VALUE']),
                        'description' => $arProperty['DESCRIPTION'],
                        'originalName' => $fileInfo['ORIGINAL_NAME'],
                        'extention' => $this->getExtention($fileInfo['ORIGINAL_NAME']),
                    ];
                }
            } elseif ($arProperty['PROPERTY_TYPE'] === 'L') {
                $value = (bool)$arProperty['VALUE'];
            } elseif ($arProperty['PROPERTY_TYPE'] === 'S' && $arProperty['USER_TYPE'] === 'HTML') {
                $value = $arProperty['~VALUE']['TEXT'];
            } elseif ($arProperty['DESCRIPTION']) {
                $value = ['value'=>$arProperty['DESCRIPTION'], 'desc' => $arProperty['VALUE']];
            } else {
                $value = $arProperty['VALUE'] ?? '';
            }

            if ($arProperty['MULTIPLE'] === 'Y') {
                $property[$arProperty['CODE']][] = $value;
            } else {
                $property[$arProperty['CODE']] = $value;
            }
        }

        return $property;
    }
}
