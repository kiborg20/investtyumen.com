<?php

declare(strict_types=1);

class Scheme extends CBitrixComponent
{
    private const IBLOCK_TYPE = 'pforinvestor';
    private const IBLOCK_CODE = 'schemes';

    public function onPrepareComponentParams($arParams)
    {
        if (!isset($arParams['ELEMENT_CODE'])) {
            throw new \RuntimeException('Not Found');
        }

        return parent::onPrepareComponentParams($arParams);
    }

    public function executeComponent()
    {
        $this->arResult['ITEM'] = CIBlockElement::GetList([
            'SORT' => 'ASC',
            'ID' => 'ASC',
        ], [
            'IBLOCK_TYPE' => self::IBLOCK_TYPE,
            'IBLOCK_CODE' => self::IBLOCK_CODE,
            'CODE' => $this->arParams['ELEMENT_CODE'],
            'ACTIVE' => 'Y',
        ])->Fetch();

        $this->includeComponentTemplate();
    }
}
