<?php

namespace Tyumip\Main\Service;

use Tyumip\Main\Base\Singleton;
use Tyumip\Main\model\IndexerTable;

class SearchService extends Singleton
{
    public function get($sValue)
    {
        return $this->getIndex($sValue);
    }

    private function getPhrasedItems(array $aPhrases): array
    {
        $aResult = [];
        foreach ($aPhrases as &$aPhrase) {
            $aPhrase['TAG'] = $aPhrase['PAGE'] ?? 'Главная';
            $aResult[] = $aPhrase;
        }

        return $aResult;
    }

    private function getDataOfIndex(string $sKey, array $aIndexes): array
    {
        $aResult = [];
        foreach ($this->getIndexesItems($aIndexes) as &$aIndex) {
            $aIndex['TAG'] = $aIndex['PAGE'] ?? 'Главная';
            $aResult[] = $aIndex;
        }

        return $aResult;
    }

    private function getIndexesItems(array $aIndexes)
    {
        $aIndexesItems = IndexerTable::getList(
            [
                'filter' => [
                    '=INDEXED_TEXT' => $aIndexes
                ]
            ]
        )->fetchAll();

        return $aIndexesItems;
    }

    private function isSingleWord($sText): bool
    {
        $aItems = explode(' ', $sText);
        return count($aItems) == 1;
    }

    private function mixPhrase(array $aWords, $aMixed = array())
    {
        static $aResult;

        $iLen = count($aWords) - 1;
        if (empty($aWords)) {
            $aResult[] = implode(' ', $aMixed);
            return;
        }

        for ($iIndex = $iLen; $iIndex >= 0; --$iIndex) {
            $tempItems = $aWords;
            $tempMix = $aMixed;

            list($aItems) = array_splice($tempItems, $iIndex, 1);
            array_unshift($tempMix, $aItems);
            $this->mixPhrase($tempItems, $tempMix);
        }

        return $aResult;
    }

    private function getAllMixPhrase(string $sPhrase): array
    {
        return $this->mixPhrase(explode(' ', $sPhrase));
    }

    private function findPhraseByText($sText)
    {
        $aFindedPhrases = IndexerTable::getList(
            [
                'filter' => [
                    '%=CONTENT' => '%' . $sText . '%'
                ],
                'limit' => 15
            ]
        )->fetchAll();

        return $aFindedPhrases;
    }

    private function getIndexByWord(string $sWord)
    {
        $aCurrentIndex = IndexerTable::getList(
            [
                'filter' => [
                    '=INDEXED_TEXT' => $sWord
                ],
                'limit' => 15
            ]
        )->fetchAll();

        if ($aCurrentIndex) {
            $aIndexedData = array_column($aCurrentIndex, 'CONTENT');
            return $this->getDataOfIndex($sWord, $aIndexedData);
        }

        $aSomethingIndexedItems = IndexerTable::getList(
            [
                'filter' => [
                    '=%INDEXED_TEXT' => '%' . $sWord . '%'
                ],
                'limit' => 15
            ]
        )->fetchAll();

        $aIndexedData = array_column($aSomethingIndexedItems, 'CONTENT');
        return $this->getDataOfIndex($sWord, $aIndexedData);

    }

    public function getIndex($sText)
    {
        if (!$this->isSingleWord($sText)) {
            $aPhrases = $this->getAllMixPhrase($sText);
            $aResult = [];

            $bFinded = false;
            foreach ($aPhrases as $aPhrase) {
                $aFindedPhrases = $this->findPhraseByText($aPhrase);
                if ($aFindedPhrases) {
                    $aResult = array_merge($aResult, $this->getPhrasedItems($aFindedPhrases));

                    $bFinded = true;
                }
            }
            if ($bFinded) {
                return $aResult;
            } else {
                $aWords = explode(' ', $sText);
                foreach ($aWords as $sWord) {
                    if (!($index=$this->getIndexByWord($sWord))) {
                        continue;
                    }

                    return $index;
                }
            }
        } else {
            return $this->getIndexByWord($sText);
        }

        return false;
    }
}