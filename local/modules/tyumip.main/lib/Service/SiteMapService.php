<?php

namespace Tyumip\Main\Service;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Landing\Help;
use Bitrix\Main\Loader;
use Bitrix\Main\Request;
use Tyumip\Main\Enums\Answer;
use Bitrix\Main\Application;
use Tyumip\Main\Helper\Helper;

class SiteMapService
{

    public function getMainPages()
    {
        if (!Loader::includeModule('iblock')) {
            return null;
        }

        return ElementTable::getList(
            [
                'filter' => [
                    '=IBLOCK_SECTION_ID' => null,
                    '=IBLOCK.CODE' => 'structure'
                ]
            ]
        )->fetchAll();
    }

    protected function writeXML($sUrl = '', $sName = '', $sParent = '', $xw, bool $hasEnd = true)
    {
        xmlwriter_start_element($xw, 'page');
            xmlwriter_start_element($xw, 'loc');
            xmlwriter_text($xw, $sUrl);
            xmlwriter_end_element($xw);
            if ($hasEnd) {
                xmlwriter_end_element($xw);
            }
    }

    private $aNewsPages = [
        'press-center' => 'news',
        'success-stories' => 'tophostory',
        'vneshneekonomicheskaya-deyatelnost' => 'internationalcooperation',
        'instrumenty-imushchestvennoj-podderzhki' => 'propertysupporttools',
        'nalogovye-lgoty' => 'nalogovyelgoty',
        'instrumenty-finansovoy-podderzhki' => 'loans',
        'investment-projects' => 'invetsproject'
    ];

    private function generateNewsPageSiteMap(string $sCurrentPage, string $sCode, $xw)
    {
        $aResult = ElementTable::getList(
            [
                'filter' => [
                    '=IBLOCK.CODE' => $this->aNewsPages[$sCode]
                ]
            ]
        )->fetchAll();

        foreach ($aResult as $aItem) {
            $this->writeXML($sCurrentPage . '/' .
                $aItem['CODE'], '', '', $xw);
        }
    }

    public function generateSiteMap()
    {
        $aMainPages = $this->getMainPages();

        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        xmlwriter_set_indent_string($xw, ' ');
        xmlwriter_start_document($xw, '1.0', 'UTF-8');
        xmlwriter_start_element($xw, 'sitemapindex');
        xmlwriter_start_attribute($xw, 'xmlns');
        xmlwriter_text($xw, 'http://www.sitemaps.org/schemas/sitemap/0.9');
        xmlwriter_end_attribute($xw);

        foreach ($aMainPages as $aMainPage)
        {
            $aSection = Helper::getSection($aMainPage['CODE'] ?? '', 50);
            if (!isset($aSection)) {
                xmlwriter_start_element($xw, 'sitemap');
                xmlwriter_start_element($xw, 'loc');
                xmlwriter_text($xw, 'https://ift.t.crtweb.ru/' . $aMainPage['CODE']);
                xmlwriter_end_element($xw);
                if (in_array($aMainPage['CODE'], array_keys($this->aNewsPages))) {
                    $this->generateNewsPageSiteMap('https://ift.t.crtweb.ru/' . $aMainPage['CODE'], $aMainPage['CODE'], $xw);
                }
                xmlwriter_end_element($xw);
                continue;
            }

            $aElements = Helper::getElementsInSection($aSection['ID']);
            $aSections = Helper::getSections($aSection, false);

            xmlwriter_start_element($xw, 'sitemap');
            xmlwriter_start_element($xw, 'loc');
            xmlwriter_text($xw, 'https://ift.t.crtweb.ru/' . $aSection['CODE']);
            xmlwriter_end_element($xw);

            if (empty($aSections)) {
                foreach ($aElements as $aElement) {
                    $this->writeXML('https://ift.t.crtweb.ru/' . $aSection['CODE'] . '/' .
                        $aElement['CODE'], '', '', $xw, !in_array($aElement['CODE'], array_keys($this->aNewsPages)));

                    if (in_array($aElement['CODE'], array_keys($this->aNewsPages))) {
                        $this->generateNewsPageSiteMap('https://ift.t.crtweb.ru/' . $aSection['CODE'] . '/' .
                            $aElement['CODE'], $aElement['CODE'], $xw);
                        xmlwriter_end_element($xw);
                    }
                }
            } else {
                foreach ($aSections as $aSectionC)
                {
                    xmlwriter_start_element($xw, 'page');
                    xmlwriter_start_element($xw, 'loc');
                    xmlwriter_text($xw, 'https://ift.t.crtweb.ru/' . $aSection['CODE'] . '/' . $aSectionC['CODE']);
                    xmlwriter_end_element($xw);

                    foreach (Helper::getElementsInSection($aSectionC['ID']) as $aItem) {
                        $this->writeXML('https://ift.t.crtweb.ru/' . $aSection['CODE'] . '/' . $aSectionC['CODE'] . '/' .
                            $aItem['CODE'], '', '', $xw, !in_array($aItem['CODE'], array_keys($this->aNewsPages)));

                        if (in_array($aItem['CODE'], array_keys($this->aNewsPages))) {
                            $this->generateNewsPageSiteMap('https://ift.t.crtweb.ru/' . $aSection['CODE'] .
                                '/' . $aSectionC['CODE'] . '/' .
                                $aItem['CODE'], $aItem['CODE'], $xw);

                            xmlwriter_end_element($xw);
                        }
                    }
                    xmlwriter_end_element($xw);
                }
            }
            xmlwriter_end_element($xw);
        }
        xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);
        $sResult = xmlwriter_output_memory($xw);
        file_put_contents('sitemap.xml', $sResult);
    }
}