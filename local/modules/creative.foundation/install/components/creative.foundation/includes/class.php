<?php

namespace creative\foundation\components;

use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
use LogicException;
use InvalidArgumentException;

class Includes extends \CBitrixComponent
{
    /**
     * {@inheritdoc}
     */
    public function onPrepareComponentParams($p)
    {
        //сохраняем битриксовую обработку входящих параметров
        $p = parent::onPrepareComponentParams($p);
        //цифровой либо буквенный идентификатор инфоблока
        $p['IBLOCK_ID'] = isset($p['IBLOCK_ID']) && trim($p['IBLOCK_ID']) !== ''
            ? trim($p['IBLOCK_ID'])
            : 'includes';
        //код элемента для вывода
        $p['CODE'] = isset($p['CODE']) && trim($p['CODE']) !== ''
            ? trim($p['CODE'])
            : null;
        //время жизни кэша
        $p['CACHE_TIME'] = !isset($p['CACHE_TIME'])
            ? 86400
            : intval($p['CACHE_TIME']);
        //без вывода шаблона
        $p['IS_SILENT'] = isset($p['IS_SILENT']) && $p['IS_SILENT'] !== 'N';
        //возвращаем параметры
        return $p;
    }

    /**
     * {@inheritdoc}
     */
    public function executeComponent()
    {
        //проверяем, чтобы был указан код включаемой области
        if ($this->arParams['CODE'] === null) {
            throw new InvalidArgumentException('Code field is empty');
        }
        $obCache = Cache::createInstance();
        $cid = "{$this->arParams['IBLOCK_ID']}_{$this->arParams['CODE']}";
        $path = 'creative_foundation/includes';
        if ($obCache->InitCache($this->arParams['CACHE_TIME'], $cid, $path)) {
            $this->arResult = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            //получаем по коду элемент
            $elements = $this->getElementsForIblock($this->arParams['IBLOCK_ID']);
            if (!empty($elements[$this->arParams['CODE']])) {
                $this->arResult = $elements[$this->arParams['CODE']];
                //вешаем теггированый кэш для очистки кэша при изменении инфоблока
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache($path);
                $CACHE_MANAGER->RegisterTag("iblock_id_{$this->arResult['iblock_id']}");
                //финализируем тегирование кеша
                $CACHE_MANAGER->EndTagCache();
                $obCache->endDataCache($this->arResult);
            } else {
                $obCache->abortDataCache();
            }
        }
        //передаем нужные данные в компонент
        if (!empty($this->arResult)) {
            //выводим возможность редактирования для битриксового интерфейса
            global $USER;
            global $APPLICATION;
            if ($USER->IsAuthorized() && $APPLICATION->GetShowIncludeAreas()) {
                //подключаем модуль инфоблоков
                if (!Loader::includeModule('iblock')) {
                    throw new LogicException('Iblock module not found');
                }
                $arButtons = \CIBlock::GetPanelButtons(
                    $this->arResult['iblock_id'],
                    $this->arResult['id'],
                    null
                );
                $this->AddIncludeAreaIcons(\CIBlock::GetComponentMenu(
                    $APPLICATION->GetPublicShowMode(),
                    $arButtons
                ));
            }
            //выводим элемент
            if (!$this->arParams['IS_SILENT']) {
                $this->IncludeComponentTemplate();
            }

            return $this->arResult;
        } else {
            return null;
        }
    }

    /**
     * @var array
     */
    protected static $elements = array();

    /**
     * Возвращает весь список элементов для указанного инфоблока.
     *
     * @param int $iblock
     *
     * @return array
     */
    protected function getElementsForIblock($iblock)
    {
        if (!isset(self::$elements[$iblock])) {
            //подключаем модуль инфоблоков
            if (!Loader::includeModule('iblock')) {
                throw new LogicException('Iblock module not found');
            }
            //задаем пустое значение по умолчанию,
            //чтобы не запрашивать пустые блоки по несколько раз
            self::$elements[$iblock] = array();
            //получаем проверенный и валидный идентификатор инфоблока
            $iblockId = $this->makeSureInIblockId($iblock);
            if ($iblockId === null) {
                throw new InvalidArgumentException("Iblock {$iblock} not found");
            }
            //запаршиваем все элементы инфоблока
            $res = \CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => $iblockId,
                    'ACTIVE' => 'Y',
                    'ACTIVE_DATE' => 'Y',
                ],
                false,
                false,
                [
                    'ID',
                    'IBLOCK_ID',
                    'CODE',
                    'NAME',
                    'PREVIEW_TEXT',
                    'DETAIL_TEXT',
                ]
            );
            while ($ob = $res->Fetch()) {
                self::$elements[$iblock][$ob['CODE']] = [
                    'name' => $ob['NAME'],
                    'id' => $ob['ID'],
                    'code' => $ob['CODE'],
                    'preview' => $ob['PREVIEW_TEXT'],
                    'detail' => $ob['DETAIL_TEXT'],
                    'iblock_id' => $ob['IBLOCK_ID'],
                ];
            }
        }

        return self::$elements[$iblock];
    }

    /**
     * Проверяет на валидность указанный инфоблок.
     *
     * @param string $iblock
     *
     * @return int|null
     */
    protected function makeSureInIblockId($iblock)
    {
        $filter = array('ACTIVE' => 'Y');
        if (is_numeric($iblock)) {
            $filter['ID'] = $iblock;
        } else {
            $filter['CODE'] = $iblock;
        }
        $res = \CIBlock::GetList(array(), $filter);
        if ($ob = $res->Fetch()) {
            return (int) $ob['ID'];
        }

        return null;
    }
}
