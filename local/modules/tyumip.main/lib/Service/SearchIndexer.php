<?php

namespace Tyumip\Main\Service;

use Tyumip\Main\Helper\Helper;
use Tyumip\Main\model\IndexerTable;

class SearchIndexer
{
    private $aNewsPages = [
        'press-center' => 'news',
        'success-stories' => 'tophostory',
        'vneshneekonomicheskaya-deyatelnost' => 'internationalcooperation',
        'instrumenty-imushchestvennoj-podderzhki' => 'propertysupporttools',
        'nalogovye-lgoty' => 'nalogovyelgoty',
        'instrumenty-finansovoy-podderzhki' => 'loans',
        'investment-projects' => 'invetsproject'
    ];

    private function convertWordToNormalFormat(string $sWord): string
    {
        $sWord = preg_replace('/[^a-zA-ZА-Яа-я0-9]/u', '', $sWord);
        $sNew = mb_strtolower($sWord);
        return $sNew;
    }

    private function splitWords(string $sText): array
    {
        $aWords = explode(' ', $sText);
        $aWords = array_filter($aWords, function ($element) {
            return !empty($element) && !in_array($element, $this->aUnions) && mb_strlen($element) > 2;
        });

        $aWords = array_map(fn($sWord): string => $this->convertWordToNormalFormat($sWord), $aWords);
        return $aWords;
    }

    private $aUnions = [
        'а', 'в', 'и', 'из', 'на', 'по', 'после', 'об', 'о', 'по', 'потому', 'как', 'зачем', 'вот', 'так', 'почему',
        "нам", 'вам', 'или',
    ];

    /**
     * Метод индексирует слова разбивая и удаляя из них html теги.
     *
     * @param string $sText
     * @param string $sUrl
     * @param string $sPageName
     *
     * @return void
     *
     * @throws \Exception
     */
    private function getIndexWords(string $sText, string $sUrl, string $sPageName = ''): void
    {
        $aMatches = [];

        $sText = preg_replace('/ +/', ' ', $sText);
        $sText = html_entity_decode($sText);
        preg_match_all('/(.*)\n/mu', $sText, $aMatches);

        $aMatches = array_filter($aMatches[1], function ($element) {
            return !empty($element) && !str_contains(' ', $element);
        });

        $aTempData = [];
        foreach ($aMatches as $aMatch) {
            $aSplittedWords = $this->splitWords($aMatch);
            $sHashedContent = hash('sha256', $aMatch . $sPageName);
            $aFilledWords = array_fill_keys($aSplittedWords, $sHashedContent);

            foreach ($aFilledWords as $sName => $aFilledWord) {
                if (isset($aTempData[$sName][$aFilledWord])) {
                    continue;
                }

                $aTempData[$sName][$aFilledWord] = 1;
                IndexerTable::add(['CONTENT' => $aFilledWord, 'INDEXED_TEXT' => $sName, 'PAGE' => $sPageName]);
            }

            IndexerTable::add(
                [
                    'CONTENT' => $aMatch,
                    'URL' => $sUrl,
                    'INDEXED_TEXT' => $sHashedContent,
                    'PAGE' => $sPageName
                ]
            );
        }

        unset($aTempData);
    }

    private function indexPage($sName, $sUrl)
    {
        global $APPLICATION;


        ob_start();
        $APPLICATION->IncludeComponent("creative.foundation:content", "investtumen", array(
            "COMPONENT_TEMPLATE" => "",
            "SEF_MODE" => "Y",    // Включить поддержку ЧПУ
            "SEF_FOLDER" => "/",    // Каталог ЧПУ (относительно корня сайта)
            "IBLOCK_ID" => "structure",    // ID или код инфоблока
            "TEMPLATE_PROPERTY" => "template",    // Свойство инфоблока, в котором хранится шаблон
            "COMPLEX_PAGE_PROPERTY" => "is_complex",    // Свойство инфоблока, в котором указывается, что на странице комплексный компонент
            "PARAM_PROPERTY" => "",    // Свойство инфоблока, в котором хранятся параметры страницы
            "PAGE_404" => "/404.php",    // Путь до страницы с ошибкой 404
            "SET_META" => "Y",    // Устанавливать мета-заголовки
            "SET_BREADCRUMBS" => "Y",    // Устанавливать хлебные крошки
            "CACHE_TYPE" => "A",    // Тип кеширования
            "CACHE_TIME" => "86400",    // Время кеширования (сек.)
            "URL" => $sUrl,
        ),
            false
        );
        ob_end_flush();
        $content = ob_get_contents();
        ob_clean();

        $this->getIndexWords(strip_tags($content), $sUrl, $sName);
    }

    public function startIndexing()
    {
        $oSiteMap = new SiteMapService();
        $aMainPages = $oSiteMap->getMainPages();

        foreach ($aMainPages as $aMainPage) {
            $aSection = Helper::getSection($aMainPage['CODE'] ?? '', 50);
            if (!isset($aSection)) {
                if ($aMainPage['CODE'] == '') {
                    $aMainPage['CODE'] = "/";
                }

                $this->indexPage($aMainPage['NAME'], $aMainPage['CODE']);
                if (in_array($aMainPage['CODE'], array_keys($this->aNewsPages))) {
                    $aItems = Helper::getElementsByIBlockCode($this->aNewsPages[$aMainPage['CODE']]);
                    foreach ($aItems as $aItem) {
                        $this->indexPage($aItem['NAME'], $aMainPage['CODE'] . '/' . $aItem['CODE'] . '/');
                    }
                }

                continue;
            }

            $aElements = Helper::getElementsInSection($aSection['ID']);
            $aSections = Helper::getSections($aSection, false);

            if (empty($aSections)) {
                foreach ($aElements as $aElement) {
                    $this->indexPage($aElement['NAME'], $aSection['CODE'] . '/' .
                        $aElement['CODE'] . '/');
                    if (in_array($aElement['CODE'], array_keys($this->aNewsPages))) {
                        $aItems = Helper::getElementsByIBlockCode($this->aNewsPages[$aElement['CODE']]);
                        foreach ($aItems as $aItem) {
                            $this->indexPage($aElement['NAME'], $aSection['CODE'] . '/' .
                                $aElement['CODE'] . '/' . $aItem['CODE'] . '/');
                        }
                    }
                }
            } else {
                foreach ($aSections as $aSectionC) {
                    foreach (Helper::getElementsInSection($aSectionC['ID']) as $aItem) {
                        $this->indexPage($aItem['NAME'], $aSection['CODE'] . '/' . $aSectionC['CODE']
                            . '/' . $aItem['CODE'] . '/');

                        if (in_array($aItem['CODE'], array_keys($this->aNewsPages))) {
                            $aItems = Helper::getElementsByIBlockCode($this->aNewsPages[$aItem['CODE']]);
                            foreach ($aItems as $aItemCur) {
                                $this->indexPage($aItemCur['NAME'], $aSection['CODE'] . '/' . $aSectionC['CODE']
                                    . '/' . $aItem['CODE'] . '/' . $aItemCur['CODE'] . '/');
                            }
                        }
                    }
                }
            }
        }

        ob_end_clean();
    }
}