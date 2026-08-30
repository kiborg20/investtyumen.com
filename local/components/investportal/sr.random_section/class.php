<?php

declare(strict_types=1);

use Bitrix\Iblock\ElementTable;

class RandomSectionStructure extends CBitrixComponent
{
    private const IBLOCK_TYPE = 'content';

    public function onPrepareComponentParams($arParams)
    {
        if (
            empty($arParams['IBLOCK']) && !isset($arParams['IS_EMPTY'])
        ) {
            throw new \RuntimeException('Not Found');
        }
        return parent::onPrepareComponentParams($arParams);
    }

    protected function insertRandomValueInArray(array &$aGenerated, int $iRandomValue, int $iMax): void
    {
        if (in_array($iRandomValue, $aGenerated)) {
            if ($iRandomValue >= 6) {
                $iRandomValue-=2;
            } else {
                $iRandomValue++;
            }

            $this->insertRandomValueInArray($aGenerated, $iRandomValue, $iMax);
        } else {
            $aGenerated[] = $iRandomValue;
        }
    }

    protected function getRandomIndex(int $iMaxGenerated = 1, int $iCountGenerateIndex = 1): array
    {
        $aGenerated = [];
        for ($iIndex = 0; $iIndex < $iCountGenerateIndex; $iIndex++) {
            $iRandom = rand(0, $iMaxGenerated-1);
            $this->insertRandomValueInArray($aGenerated, $iRandom, $iMaxGenerated - 1);
        }

        return $aGenerated;
    }

    public function executeComponent()
    {
        $section = $this->arParams['SECTION'];
        $iBlock = $this->arParams['IBLOCK'];
        $sCode = $this->arParams['ELEMENT_CODE'];
        $sIblockType = $this->arParams['IBLOCK_TYPE'];
        $elementCount = $this->arParams['ELEMENT_COUNT'];

        if (!isset($sIblockType)) {
            $sIblockType = self::IBLOCK_TYPE;
        }

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
                ] + ($sCode != '' ? ['!CODE' => $sCode] : []),
        ])->fetchAll();

        $aRandomIndexs = $this->getRandomIndex(count($elements), $elementCount);
        foreach ($aRandomIndexs as $iIndex) {

            if($elements[$iIndex]['PREVIEW_PICTURE']) {
                $elements[$iIndex]['PREVIEW_PICTURE'] = CFile::GetPath($elements[$iIndex]['PREVIEW_PICTURE']);
            }

            $this->arResult['ITEMS'][] = $elements[$iIndex];
        }

        $this->includeComponentTemplate();
    }
}
