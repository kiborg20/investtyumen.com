<?php

declare(strict_types=1);

use Bitrix\Iblock\ElementTable;

class OregioneIntro extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        if (
            empty($arParams['SECTION']) ||
            empty($arParams['IBLOCK'])
        ) {
            throw new \RuntimeException('Not Found');
        }

        return parent::onPrepareComponentParams($arParams);
    }

    public function executeComponent()
    {
        $sSection = $this->arParams['SECTION'];
        $iBlock = $this->arParams['IBLOCK'];
        $iBlockType = $this->arParams['IBLOCK_TYPE'];

        $aItem = ElementTable::getList(
            [
                'filter' => [
                    '=IBLOCK.CODE' => $iBlock,
                    '=IBLOCK_SECTION.CODE' => $sSection,
                    '=ACTIVE' => 'Y',
                ] + (isset($iBlockType) ? ['=IBLOCK.IBLOCK_TYPE_ID' => $iBlockType] : [])
            ]
        )->fetch();

        $this->arResult['ITEM'] = $aItem;
        $this->includeComponentTemplate();
    }
}
