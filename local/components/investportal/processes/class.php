<?php

declare(strict_types=1);

class Processes extends CBitrixComponent
{
    private const IBLOCK_TYPE = 'pforinvestor';
    private const IBLOCK_CODE = 'processes';

    public function executeComponent()
    {
        $res = CIBlockElement::GetList([
            'SORT' => 'ASC',
            'ID' => 'ASC',
        ], [
            'IBLOCK_TYPE' => self::IBLOCK_TYPE,
            'IBLOCK_CODE' => self::IBLOCK_CODE,
            'ACTIVE' => 'Y',
        ]);

        $this->arResult['ITEMS'] = [];
        while ($item = $res->Fetch()) {
            if ($item['CODE'] === 'header') {
                $this->arResult['HEADER'] = $item;
            } else {
                $this->arResult['ITEMS'][] = $item;
            }
        }

        $this->includeComponentTemplate();
    }
}
