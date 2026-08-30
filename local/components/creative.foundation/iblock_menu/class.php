<?php

namespace creative\foundation\components;

use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
use CIBlockElement;
use CIBlockSection;
use CFile;
use LogicException;
use InvalidArgumentException;

class IblockMenu extends \CBitrixComponent
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
            : 'menu';
        //цифровой либо буквенный идентификатор раздела инфоблока
        $p['SECTION_ID'] = isset($p['SECTION_ID']) && trim($p['SECTION_ID']) !== ''
            ? trim($p['SECTION_ID'])
            : null;
        //время жизни кэша
        $p['CACHE_TIME'] = !isset($p['CACHE_TIME'])
            ? 86400
            : intval($p['CACHE_TIME']);
        //возвращаем параметры
        return $p;
    }

    /**
     * {@inheritdoc}
     */
    public function executeComponent()
    {
        //подключаем модуль инфоблоков
        if (!Loader::includeModule('iblock')) {
            throw new LogicException('Iblock module not found');
        }
        $obCache = Cache::createInstance();
        $cid = "{$this->arParams['IBLOCK_ID']}_{$this->arParams['SECTION_ID']}";
        $path = 'creative_foundation/iblock_menu';
        if ($obCache->InitCache($this->arParams['CACHE_TIME'], $cid, $path)) {
            $menu = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            //пробуем найти указанный в настройках инфоблок
            $iblock = $this->makeSureInIblockId($this->arParams['IBLOCK_ID']);
            if ($iblock === null) {
                throw new InvalidArgumentException("Iblock {$this->arParams['IBLOCK_ID']} not found");
            } else {
                $this->arParams['IBLOCK_ID'] = $iblock;
            }
            //пробуем выстроить меню по указанным данным
            $menu = $this->buildMenu($iblock, $this->arParams['SECTION_ID']);
            //если ничего не нашли, то кэш не пишем
            if (empty($menu)) {
                $obCache->abortDataCache();
            } else {
                $obCache->endDataCache($menu);
            }
        }
        //возвращаем данные о требуемом меню
        return $menu;
    }

    /**
     * @var array
     */
    protected static $menu = array();

    /**
     * Строит меню из данных инфоблока.
     *
     * @param int    $iblock
     * @param string $type
     * @param int    $depth
     *
     * @return array|null
     */
    protected function buildMenu($iblock, $type)
    {
        $return = null;
        //если для данного инфоблока меню еще не искали,
        if (!isset(self::$menu[$iblock])) {
            //то получаем все данные из меню
            $res = CIBlockSection::GetList(
                ['depth_level' => 'asc'],
                [
                    'IBLOCK_ID' => $iblock,
                    'ACTIVE' => 'Y',
                ],
                false
            );
            //получаем все разделы, которые нам потребуются
            $sections = [];
            while ($section = $res->Fetch()) {
                $sections[$section['ID']] = [
                    'id' => $section['ID'],
                    'type' => 'section',
                    'parent' => $section['IBLOCK_SECTION_ID'] ? $section['IBLOCK_SECTION_ID'] : null,
                    'label' => $section['NAME'],
                    'url' => $section['CODE'],
                    'sort' => $section['SORT'],
                    'description' => $section['DESCRIPTION'],
                    'image' => isset($section['PICTURE'])
                        ? CFile::GetFileArray($section['PICTURE'])
                        : null,
                ];
            }
            //получаем все элементы, которые нам могут потребоваться
            $elements = [];
            $res = CIBlockElement::GetList(
                ['sort' => 'asc', 'name' => 'asc'],
                [
                    'IBLOCK_ID' => $iblock,
                    'ACTIVE' => 'Y',
                    'SECTION_ID' => array_merge([$parent['ID']], array_keys($sections)),
                ],
                false,
                false,
                [
                    'ID',
                    'CODE',
                    'NAME',
                    'IBLOCK_SECTION_ID',
                    'SORT',
                    'PREVIEW_TEXT',
                    'PREVIEW_PICTURE',
                ]
            );
            while ($element = $res->Fetch()) {
                $elements[] = [
                    'id' => $element['ID'],
                    'type' => 'element',
                    'parent' => $element['IBLOCK_SECTION_ID'] ? $element['IBLOCK_SECTION_ID'] : null,
                    'label' => $element['NAME'],
                    'url' => $element['CODE'],
                    'sort' => $element['SORT'],
                    'description' => $element['PREVIEW_TEXT'],
                    'image' => isset($element['PREVIEW_PICTURE'])
                        ? CFile::GetFileArray($element['PREVIEW_PICTURE'])
                        : null,
                ];
            }
            //собираем массив для меню
            self::$menu[$iblock] = array_merge($sections, $elements);
        }

        if (!empty($type)) {
            $id = null;
            foreach (self::$menu[$iblock] as $item) {
                if (
                    $item['type'] === 'section'
                    && ($item['url'] === $type || intval($item['id']) === intval($type))
                ) {
                    $id = $item['id'];
                }
            }
            if ($id) {
                $return = self::sortMenu(self::$menu[$iblock], $id);
            }
        } else {
            $return = self::sortMenu(self::$menu[$iblock]);
        }

        return $return;
    }

    /**
     * Сортирует меню и выстраивает в иерархическом порядке.
     *
     * @param array $menu
     *
     * @return array
     */
    protected static function sortMenu(&$menu, $parent = null, $depth = 1)
    {
        $return = [];
        $sort = [];
        $i = 0;
        foreach ($menu as $item) {
            if ($item['parent'] !== $parent) {
                continue;
            }
            $return[$i] = [
                $item['label'],
                $item['url'],
                [],
                [
                    'FROM_IBLOCK' => true,
                    'IS_PARENT' => false,
                    'DEPTH_LEVEL' => $depth,
                    'ID' => $item['id'],
                    'IMAGE' => $item['image'],
                    'DESCRIPTION' => $item['description'],
                ],
                '',
            ];
            $sort[$i] = $item['sort'];
            ++$i;
        }
        array_multisort($sort, SORT_ASC, $return);
        $new = [];
        foreach ($return as $key => $item) {
            $children = self::sortMenu($menu, $item[3]['ID'], $depth + 1);
            if ($children) {
                $item[3]['IS_PARENT'] = true;
                $new[] = $item;
                $new = array_merge($new, $children);
            } else {
                $new[] = $item;
            }
        }

        return $new;
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
