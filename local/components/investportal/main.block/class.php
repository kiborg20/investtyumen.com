<?php

declare(strict_types=1);

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\ORM\Query\Result;
use Tyumip\Main\Enums\Answer;
use Tyumip\Main\Helper\Helper;
use Tyumip\Main\model\CompiledElementTable;
use Tyumip\Main\Service\RequestService;

class MainBlock extends CBitrixComponent implements Controllerable
{
    private const IBLOCK_TYPE = 'poregione';

    public function configureActions()
    {
        return [
            'getByFilter' => [
                'prefilters' => [],
            ],
        ];
    }

    /**
     * Action получения данных по фильтрам (ajax)
     *
     * @param $aRequest
     *
     * @return array
     */
    public function getByFilterAction($aRequest)
    {
        if (!CModule::IncludeModule("iblock")) {
            return RequestService::prepareAnswer('Внутреняя ошибка сервиса', Answer::$BadRequest);
        }

        if (!isset($aRequest['IBLOCK'])) {
            return RequestService::prepareAnswer('Отсутствует ID', Answer::$BadRequest);
        } else if (!isset($aRequest['FILTERS'])) {
            $aRequest['FILTERS'] = [];
        }

        if (isset($aRequest['SEARCH'])) {
            $this->arParams['SEARCH'] = $aRequest['SEARCH'];
        }

        $this->arParams['FILTER'] = true;
        $this->arParams['FILTERS_CODE'] = array_keys($aRequest['FILTERS']);
        $this->arParams['FILTERS'] = $aRequest['FILTERS'];

        $iOffset = 0;
        if (isset($this->arParams['FILTERS']['OFFSET'])) {
            $iOffset = $this->arParams['FILTERS']['OFFSET'];
        } else if (isset($aRequest['PAGE'])) {
            $iOffset = ($aRequest['PAGE'] - 1) * $aRequest['LIMIT'] ?? 9;
        }

        $oResult = $this->getElementsResultById($aRequest['IBLOCK'], $aRequest['TYPE'], $this->arParams['FILTERS'],
            $this->arParams['SEARCH'], $iOffset ?? 0, (int)$aRequest['LIMIT'] ?? 9);
        $this->arParams['FILTER'] = false;

        $iCount = $oResult->getCount();
        $this->parseElements($oResult);

        if (empty($this->arResult['ITEMS']) && !isset($this->arResult['HEADER'])) {
            return RequestService::prepareAnswer(json_encode($aRequest), Answer::$NoContent);
        }

        $this->arResult['IS_AJAX'] = true;
        $this->arResult['COUNT'] = $iCount;
        $this->arResult['LIMIT'] = $aRequest['LIMIT'];
        $this->arResult['PAGE'] = $aRequest['PAGE'];

        if (!isset($aRequest['TEMPLATE'])) {
            return RequestService::prepareAnswer(json_encode($this->arResult), Answer::$OK);
        }

        $this->setTemplateName($aRequest['TEMPLATE']);
        ob_start();
        $this->includeComponentTemplate();
        ob_end_flush();
        $sResult = ob_get_contents();

        return RequestService::prepareAnswer($sResult, Answer::$OK);
    }

    public function onPrepareComponentParams($arParams)
    {
        if (\Bitrix\Main\Context::getCurrent()->getRequest()->isAjaxRequest()) {
            return parent::onPrepareComponentParams($arParams);
        }

        if (
            empty($arParams['IBLOCK']) && !isset($arParams['IS_EMPTY'])
        ) {
            throw new \RuntimeException('Not Found');
        }
        return parent::onPrepareComponentParams($arParams);
    }

    /**
     * Метод генерирует массив для выборки из массива названий.
     * @param array $aFiltersName
     * @return array
     */
    protected function getSelectFilters(array $aFiltersName)
    {
        $aResult = [];
        foreach ($aFiltersName as $aFilterName) {
            $aResult += [$aFilterName => $aFilterName];
        }

        return $aResult;
    }

    /**
     * Метод корректирует входной массив фильтров для использования в фильтрации (d7)
     * @param array $aFilters
     * @return array
     */
    protected function getCorrectFilters(array $aFilters)
    {
        $aResult = [];
        foreach ($aFilters as $sFilterName => $aFilter) {
            if ($aFilter == '' || empty($aFilter)) {
                continue;
            }

            $aResult['=' . $sFilterName . 'VALUE'] = $aFilter;
        }

        return $aResult;
    }

    /**
     * Метод изменяет значения на "id свойства" по "Значению свойства"
     * @param $sIBlockCode
     * @param $aFilters
     *
     * @return void
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function getIdPropertyByValue($sIBlockCode, &$aFilters): void
    {
        foreach ($aFilters as $sPropertyCode => &$sValue) {
            $aValues = Helper::getListOfValuesFilter($sIBlockCode, $sPropertyCode);
            if (is_array($sValue)) {
                foreach ($sValue as &$Value) {
                    if (isset($aValues[$Value])) {
                        $Value = $aValues[$Value];
                    }
                }

                unset($aValues);
                continue;
            }

            if (isset($aValues[$sValue])) {
                $sValue = $aValues[$sValue];
            }

            unset($aValues);
        }
    }

    /**
     * Метод получает элементы в виде объектво по id (инфоблока) и фильтрам
     * @param string $sIBlockId
     *
     * @return Result
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function getElementsResultById(string $sIBlockId, ?string $sIBlockType, ?array $aFilters = [], ?string $sSearch = '', ?int $iOffset = 0, ?int $iLimit = 9): Result
    {
        $newEntity = CompiledElementTable::getInstance(Helper::getIblockId($sIBlockId));
        $aSelect = [
            '*',
        ];

        $aFiltersList = [
            '=ACTIVE' => 'Y'
        ];

        $oDateTime = null;
        $oDateLast = null;
        if (array_key_exists('date', $aFilters) && !empty($aFilters['date']) && $aFilters['date'] != '') {
            $oDateTime = new DateTime($aFilters['date'] . ' 00:00:00');
            $oDateLast = new DateTime($aFilters['date'] . ' 23:59:59');
        }

        unset($aFilters['date']);


        // Подготовка фильтров и выборки по фильтрам.
        $this->getIdPropertyByValue($sIBlockId, $aFilters);
        $aSelect = array_merge($aSelect, $this->getSelectFilters(array_keys($aFilters)));
        $aFiltersList = array_merge($aFiltersList, $this->getCorrectFilters($aFilters));
        $aFiltersList += (($sSearch != '' && isset($sSearch)) ? ['%NAME' => $sSearch] : []);
        $aFiltersList += (($oDateTime == null) ? [] : ['><DATE_CREATE' => [$oDateTime, $oDateLast]]);

        $oRes = $newEntity::getList([
            'select' => $aSelect,
            'filter' => $aFiltersList,
            'order' =>
                [
                    'SORT' => 'ASC',
                    'ID' => 'ASC',
                ],
            'limit' => $iLimit,
            'offset' => $iOffset,
            'count_total' => true,
        ]);

        return $oRes;
    }

    /**
     * Метод получает элементы в виде объектов.
     *
     * @param string $sIBlockType
     * @param string $sIBlock
     * @param string $sCode
     * @param string $sSection
     * @param int $iLimit
     *
     * @return Result
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function getElementsResult(?string $sIBlockType, ?string $sIBlock, ?string $sCode, ?string $sSection, ?int $iLimit): Result
    {
        $sortField = $this->arParams['SORT_FIELD'] ?? 'SORT';
        $sortOrder = $this->arParams['SORT_ORDER'] ?? 'ASC';
        $oRes = ElementTable::getList([
            'select' =>
                [
                    '*',
                ],
            'order' =>
                [
                    $sortField => $sortOrder,
                    'ID' => 'ASC',
                ],
            'filter' => [
                    '=IBLOCK.IBLOCK_TYPE_ID' => $sIBlockType,
                    '=IBLOCK.CODE' => $sIBlock,
                    '=ACTIVE' => 'Y',
                ] + ($sCode != '' ? ['=CODE' => $sCode] : []) + ($sSection != '' ? ['=IBLOCK_SECTION.CODE' => $sSection] : []),
            'limit' => $iLimit,
            'count_total' => true
        ]);

        return $oRes;
    }

    /**
     * Метод парсит элементы с запроса
     *
     * @param Result $oRes
     *
     * @return void
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function parseElements(Result $oRes, ?string $sCode = null)
    {
        while ($element = $oRes->Fetch()) {
            $element += Helper::getIBlockProperties($element['ID']);
            $bFilterCont = false;
            if ($this->arParams['FILTER'] && isset($this->arParams['FILTERS_CODE']) && isset($this->arParams['FILTERS'])) {
                foreach ($this->arParams['FILTERS_CODE'] as $sFilter) {
                    if (!isset($this->arParams['FILTERS'][$sFilter])) {
                        continue;
                    }

                    if ($this->arParams['FILTERS'][$sFilter] == '') {
                        continue;
                    }

                    $sFilterName = '';
                    if (!isset($element[strtolower($sFilter)]) && !isset($element[strtoupper($sFilter)])) {
                        $bFilterCont = true;
                        break;
                    } else if (isset($element[strtolower($sFilter)])) {
                        $sFilterName = strtolower($sFilter);
                    } else {
                        $sFilterName = strtoupper($sFilter);
                    }

                    if ($element[$sFilterName]['PROPERTY_TYPE'] == 'S') {
                        if ($element[$sFilterName]['PROPERTY_VALUE'] != $this->arParams['FILTERS'][$sFilter]) {
                            $bFilterCont = true;
                            break;
                        }

                        continue;
                    }

                    if ($element[$sFilterName]['PROPERTY_ENUM_VALUE'] != $this->arParams['FILTERS'][$sFilter]) {
                        if (is_array($this->arParams['FILTERS'][$sFilter]) &&
                            in_array($element[$sFilterName]['PROPERTY_ENUM_VALUE'], $this->arParams['FILTERS'][$sFilter])) {
                            continue;
                        }

                        $bFilterCont = true;
                        break;
                    }
                }
            }

            if ($bFilterCont) {
                continue;
            }

            if ($element['CODE'] === 'header') {
                $this->arResult['HEADER'] = $element;
            } else if (isset($sCode)) {
                $this->arResult['HEADER'] = $element;
            } else {
                $this->arResult['ITEMS'][] = $element;
            }
        }
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

        $iPage = $this->arParams['PAGE'] ?? 1;
        $iLimit = $this->arParams['LIMIT'] ?? 100;
        if (!isset($sIblockType)) {
            $sIblockType = self::IBLOCK_TYPE;
        }

        $sect = SectionTable::getList([
            'select' => ['PICTURE'],
            'filter' => [
                '=CODE' => $section,
                '=IBLOCK.CODE' => $iBlock,
            ],
        ])->fetch();
        $this->arResult['SECTION']['PICTURE'] = CFile::GetPath($sect['PICTURE']);
        $this->arResult['ITEMS'] = [];

        $oRes = $this->getElementsResult($sIblockType, $iBlock, $sCode, $section, $iLimit);
        $iCount = $oRes->getCount();
        $this->parseElements($oRes, $sCode);

        $this->arResult['COUNT'] = $iCount;
        $this->arResult['LIMIT'] = $iLimit;
        $this->arResult['PAGE'] = $iPage;

        $this->arResult['PAGES'] = ceil($iCount / $iLimit);
        if (empty($this->arResult['ITEMS']) && !isset($this->arResult['HEADER'])) {
            return;
        }

        CJSCore::Init(array('ajax', 'window'));
        $this->includeComponentTemplate();
    }
}