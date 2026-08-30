<?php
declare(strict_types=1);

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;

class SferyRostaHome extends \CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {
        if (!Loader::includeModule('iblock')) {
            throw new LogicException('Iblock module not found');
        }
        if (
            empty($params['SECTION']) ||
            empty($params['IBLOCK_CODE'])
        ) {
            throw new \RuntimeException('Not Found');
        }

        return parent::onPrepareComponentParams($params);
    }


    public function executeComponent()
    {
        $sSection = $this->arParams['SECTION'];
        $iBlockCode = $this->arParams['IBLOCK_CODE'];
        $iBlockType = $this->arParams['IBLOCK_TYPE'];
        $iBlockHome = 'for-home';

        $arItem = ElementTable::getList(
            [
                'filter' => [
                        '=IBLOCK.CODE' => $iBlockCode,
                        '=IBLOCK_SECTION.CODE' => $sSection,
                        '=ACTIVE' => 'Y',
                    ] + (isset($iBlockType) ? ['=IBLOCK.IBLOCK_TYPE_ID' => $iBlockType] : [])
            ]
        )->fetchAll();

        $arItemHome = ElementTable::getList(
            [
                'select' => ['*'],
                'filter' => [
                        '=IBLOCK.CODE' => $iBlockHome,
                        '=ACTIVE' => 'Y',
                    ]
            ]
        )->fetchAll();

        foreach ($arItemHome as $key=>$element) {
            $dbProperty = \CIBlockElement::getProperty(
                $this->getIblockId($iBlockHome),
                (int)$element['ID'],
            );
            while ($arProperty = $dbProperty->GetNext()) {
                $arItemHome[$key][$arProperty['CODE']] = $arProperty['VALUE'];
            }

            if($element['PREVIEW_PICTURE']) {
                $arItemHome[$key]['PREVIEW_PICTURE'] = CFile::GetPath($element['PREVIEW_PICTURE']);
            }
            $arItemHome[$element['CODE']] = $arItemHome[$key];
            unset($arItemHome[$key]);
        }

        foreach ($arItem as $index => $item) {

            if(is_array($arItemHome[$item['CODE']])) {
                $item['PREVIEW_PICTURE'] = $arItemHome[$item['CODE']]['PREVIEW_PICTURE'];
                $item['RIGHT_UP'] = $arItemHome[$item['CODE']]['RIGHT_UP'];
                $item['RIGHT_DOWN'] = $arItemHome[$item['CODE']]['RIGHT_DOWN'];
                $item['LEFT_UP'] = $arItemHome[$item['CODE']]['LEFT_UP'];
                $item['LEFT_DOWN'] = $arItemHome[$item['CODE']]['LEFT_DOWN'];
                $item['LINK'] = $arItemHome[$item['CODE']]['LINK'];
                $item['IN_MENU'] = true;
                $arItem[$index] = $item;
            }
        }

        $this->arResult['ITEMS'] = $arItem;
        $this->includeComponentTemplate();
    }

    protected function getIblockId($iblockCode): int
    {
        return (int) IblockTable::getRow([
            'filter' => ['=CODE' => $iblockCode],
            'select' => ['ID'],
        ])['ID'];
    }
}
