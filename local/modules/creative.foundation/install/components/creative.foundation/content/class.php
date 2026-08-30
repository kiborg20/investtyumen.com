<?php

namespace creative\foundation\components;

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;
use Bitrix\Iblock\InheritedProperty\ElementValues;
use Bitrix\Iblock\InheritedProperty\SectionValues;
use Bitrix\Iblock\Component\Tools;
use LogicException;
use InvalidArgumentException;
use UnexpectedValueException;

class Content extends \CBitrixComponent
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
            : 'content';
        //свойство, в котором хранится шаблон страницы
        $p['TEMPLATE_PROPERTY'] = isset($p['TEMPLATE_PROPERTY']) && trim($p['TEMPLATE_PROPERTY']) !== ''
            ? trim($p['TEMPLATE_PROPERTY'])
            : 'template';
        //свойство, в котором хранятся параметры страницы
        $p['PARAM_PROPERTY'] = isset($p['PARAM_PROPERTY']) && trim($p['PARAM_PROPERTY']) !== ''
            ? trim($p['PARAM_PROPERTY'])
            : null;
        //свойство, в котором хранятся шруппы, для которых доступна данная страница
        $p['ACCESS_PROPERTY'] = isset($p['ACCESS_PROPERTY']) && trim($p['ACCESS_PROPERTY']) !== ''
            ? trim($p['ACCESS_PROPERTY'])
            : null;
        //свойство, которое указывает, что на странице будет расположен комплесный компонент
        $p['COMPLEX_PAGE_PROPERTY'] = isset($p['COMPLEX_PAGE_PROPERTY']) && trim($p['COMPLEX_PAGE_PROPERTY']) !== ''
            ? trim($p['COMPLEX_PAGE_PROPERTY'])
            : null;
        //url для переопределения
        $p['URL'] = isset($p['URL']) && trim($p['URL']) !== ''
            ? trim($p['URL'], '/\\ ')
            : $this->getRequestedPage();
        //время жизни кэша
        $p['CACHE_TIME'] = !isset($p['CACHE_TIME'])
            ? 86400
            : intval($p['CACHE_TIME']);
        //страница 404
        $p['PAGE_404'] = isset($p['PAGE_404']) && trim($p['PAGE_404']) !== ''
            ? trim($p['PAGE_404'])
            : '/404.php';
        //Ссылка, на которую нужно переадресовать пользователя, если у него не хватает прав на просмотр
        $p['PAGE_403'] = isset($p['PAGE_403']) && trim($p['PAGE_403']) !== ''
            ? trim($p['PAGE_404'])
            : '/auth/';
        //устанавливать ли мета-теги
        $p['SET_META'] = !isset($p['SET_META']) || $p['SET_META'] !== 'N';
        //устанавливать ли хлебные крошки
        $p['SET_BREADCRUMBS'] = !isset($p['SET_BREADCRUMBS']) || $p['SET_BREADCRUMBS'] !== 'N';
        $p['IS_EMPTY_SECTION'] = 'empty_section';
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
        $cid = "{$this->arParams['IBLOCK_ID']}_{$this->arParams['URL']}";
        $path = 'creative_foundation/content';
        if ($obCache->InitCache($this->arParams['CACHE_TIME'], $cid, $path)) {
            list($pathInfo, $isPathFull) = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            //пробуем найти указанный в настройках инфоблок
            $iblock = $this->makeSureInIblockId($this->arParams['IBLOCK_ID']);
            if ($iblock === null) {
                throw new InvalidArgumentException("Iblock {$this->arParams['IBLOCK_ID']} not found");
            } else {
                $this->arParams['IBLOCK_ID'] = $iblock;
            }
            //вешаем теггированый кэш для очистки кэша при изменении инфоблока
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($path);
            $CACHE_MANAGER->RegisterTag("iblock_id_{$iblock}");
            //собираем имена свойств, которые нужно будет подгрузить
            //вместе с сущностями
            $propertiesToLoad = [];

            if ($this->arParams['IS_EMPTY_SECTION']) {
                $propertiesToLoad[] = $this->arParams['IS_EMPTY_SECTION'];
            }
            if ($this->arParams['TEMPLATE_PROPERTY']) {
                $propertiesToLoad[] = $this->arParams['TEMPLATE_PROPERTY'];
            }
            if ($this->arParams['PARAM_PROPERTY']) {
                $propertiesToLoad[] = $this->arParams['PARAM_PROPERTY'];
            }
            if ($this->arParams['ACCESS_PROPERTY']) {
                $propertiesToLoad[] = $this->arParams['ACCESS_PROPERTY'];
            }
            if ($this->arParams['COMPLEX_PAGE_PROPERTY']) {
                $propertiesToLoad[] = $this->arParams['COMPLEX_PAGE_PROPERTY'];
            }

            //пробуем найти указнный url в сущностях инфоблока
            list($pathInfo, $isPathFull) = $this->parse(
                $this->arParams['IBLOCK_ID'],
                $this->arParams['URL'],
                $propertiesToLoad
            );

            //финализируем тегирование кеша
            $CACHE_MANAGER->EndTagCache();
            //если ничего не нашли, то кэш не пишем
            if (empty($pathInfo)) {
                $obCache->abortDataCache();
            } else {
                //определяем сео-теги для последнего элемента в цепочке
                $currentKey = count($pathInfo) - 1;
                $pathInfo[$currentKey]['seo'] = $this->getMeta(
                    $iblock,
                    $pathInfo[$currentKey]
                );
                $obCache->endDataCache([$pathInfo, $isPathFull]);
            }
        }

        //передаем нужные данные в компонент
        if (
            ($current = end($pathInfo))
            //путь должен определиться полностью либо последний его элемент должен быть комплексным
            && ($isPathFull || !empty($current[$this->arParams['COMPLEX_PAGE_PROPERTY']]))
        ){
            global $USER;
            //передаем данные в шаблон
            $this->arResult['path'] = $pathInfo;
            $this->arResult['current'] = end($pathInfo);
            //проверяем права на доступ
            if (!$this->checkAccess($this->arParams['ACCESS_PROPERTY'], $pathInfo)) {
                if ($USER->IsAuthorized()) {
                    //если пользователь уже авторизован, но не проходит проверку
                    //значит ему не нужно видеть эту страницу - выводим 404
                    Tools::process404(
                        '',
                        true,
                        true,
                        true,
                        $this->arParams['PAGE_404']
                    );
                } elseif (!empty($this->arParams['PAGE_403'])) {
                    //если указана ссылка на страницу авторизации, то переходим на нее
                    LocalRedirect(
                        $this->arParams['PAGE_403']
                        .'?'
                        .http_build_query([
                            'back' => Application::getInstance()->getContext()->getRequest()->getRequestUri()
                        ])
                    );
                } else {
                    //в противном случае бросаем исключение
                    throw new UnexpectedValueException('Acces denied');
                }
            }
            global $APPLICATION;
            //устанавливаем мета-теги страницы
            if ($this->arParams['SET_META'] && $isPathFull) {
                $APPLICATION->SetPageProperty('title', $this->arResult['current']['seo']['title']);
                $APPLICATION->SetPageProperty('keywords', $this->arResult['current']['seo']['keywords']);
                $APPLICATION->SetPageProperty('description', $this->arResult['current']['seo']['description']);
                $APPLICATION->SetTitle($this->arResult['current']['seo']['h1']);
            }
            //устанавливаем хлебные крошки
            if ($this->arParams['SET_BREADCRUMBS']) {
                foreach ($this->arResult['path'] as $item) {
                    $sLink = $item['url'];
                    if ($item['empty_section']) {
                        $sLink = "";
                    }

                    $APPLICATION->AddChainItem($item['name'], $sLink , false);
                }
            }
            //выводим возможность редактирования для битриксового интерфейса
            if ($USER->IsAuthorized() && $APPLICATION->GetShowIncludeAreas()) {
                $arButtons = \CIBlock::GetPanelButtons(
                    $this->arResult['current']['iblock'],
                    $this->arResult['current']['type'] === 'element' ? $this->arResult['current']['id'] : null,
                    $this->arResult['current']['type'] === 'section' ? $this->arResult['current']['id'] : null
                );
                $this->AddIncludeAreaIcons(\CIBlock::GetComponentMenu(
                    $APPLICATION->GetPublicShowMode(),
                    $arButtons
                ));
            }
            //подключаем шаблон вывода
            $this->IncludeComponentTemplate(
                !empty($this->arResult['current'][$this->arParams['TEMPLATE_PROPERTY']])
                    ? $this->arResult['current'][$this->arParams['TEMPLATE_PROPERTY']]
                    : 'template'
            );

            return $this->arResult['current'];
        } else {
            //если не нашли вообще ничего, то выводим 404 ошибку
            Tools::process404(
                '',
                true,
                true,
                true,
                $this->arParams['PAGE_404']
            );

            return null;
        }
    }

    /**
     * Ищет элемент или раздел по указанному пути.
     *
     * @param int    $iblock
     * @param string $page
     * @param array  $propertiesToLoad
     *
     * @return array
     */
    protected function parse($iblock, $page, array $propertiesToLoad = array())
    {
        //парсим url в массив
        $url = explode('/', $page);
        $count = count($url);
        //сначала проверяем на секции, если секций не нашли или есть еще звено с элементом
        //то проверяем еще и существование элемента
        $path = array();
        $elementCode = null;
        if ($count > 1 || $url[0] !== '') {
            $path = $this->getSectionsByCodes(
                $iblock,
                $url,
                $propertiesToLoad
            );
            //если после определения секций еще остались коды, то пробуем найти элемент
            if (count($path) < $count) {
                $elementCode = $url[count($path)];
            }
        } else {
            $elementCode = $url[0];
        }
        //если необходимо найти элемент, то пробуем найти элемент с подходящим кодом
        //который принадлежит определенному нами разделу или корню
        if ($elementCode !== null) {
            $sectionId = null;
            if ($path) {
                $parent = end($path);
                $sectionId = $parent['id'];
            }
            $element = $this->getElementByCode(
                $iblock,
                $elementCode,
                $sectionId,
                $propertiesToLoad
            );
            if ($element) {
                $path[] = $element;
            }
        }
        //удалось ли обработать путь полностью или только частично
        $isFull = $count === count($path);
        //в любом случае нужно попробовать найти главную страницу
        //и поместить ее в начало списка
        if ($path && $elementCode !== '') {
            $element = $this->getElementByCode(
                $iblock,
                '',
                false,
                $propertiesToLoad
            );
            if ($element) {
                array_unshift($path, $element);
            }
        }

        return [$path, $isFull];
    }

    /**
     * Ищет разделы по указанным кодам
     *
     * @param int   $iblock
     * @param array $codes
     * @param array $propertiesToLoad
     */
    protected function getSectionsByCodes($iblock, array $codes, array $propertiesToLoad = array())
    {
        $return = array();
        $select = array(
            'ID',
            'NAME',
            'CODE',
            'DEPTH_LEVEL',
            'IBLOCK_SECTION_ID',
            'DESCRIPTION',
            'DETAIL_PAGE_URL',
            'PICTURE',
            'DETAIL_PICTURE',
            'SECTION_PAGE_URL',
            'IBLOCK_ID',
        );
        foreach ($propertiesToLoad as $prop) {
            $select[] = 'UF_'.strtoupper($prop);
        }
        //получаем список всех разделов, у которых подходящие символьные коды
        $res = \CIBlockSection::GetList(
            array('depth_level' => 'asc', 'id' => 'asc'),
            array(
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => $iblock,
                'CODE' => $codes,
            ),
            false,
            $select
        );
        $sections = array();
        while ($ob = $res->GetNext()) {
            $arSection = array(
                'type' => 'section',
                'id' => (int) $ob['ID'],
                'iblock' => (int) $ob['IBLOCK_ID'],
                'name' => $ob['NAME'],
                'code' => $ob['CODE'],
                'url' => $ob['SECTION_PAGE_URL'],
                'preview_text' => '',
                'preview_picture' => !empty($ob['PICTURE']) ? \CFile::GetFileArray($ob['PICTURE']) : null,
                'detail_text' => $ob['DESCRIPTION'],
                'detail_picture' => !empty($ob['DETAIL_PICTURE']) ? \CFile::GetFileArray($ob['DETAIL_PICTURE']) : null,
                'IBLOCK_SECTION_ID' => $ob['IBLOCK_SECTION_ID'],
            );
            foreach ($propertiesToLoad as $prop) {
                $key = 'UF_'.strtoupper($prop);
                $arSection[$prop] = isset($ob[$key]) ? $ob[$key] : null;
            }
            //выстраиваем по коду и уровню вложенности
            $sections["{$ob['CODE']}_".($ob['DEPTH_LEVEL'] - 1)] = $arSection;
        }
        //пробуем собрать путь из разделов
        $lastParent = null;
        $count = count($codes);
        for ($i = 0; $i < $count; ++$i) {
            if (
                isset($sections["{$codes[$i]}_{$i}"])
                && (
                    $i === 1 && $sections["{$codes[$i]}_{$i}"]['IBLOCK_SECTION_ID'] == null
                    || $sections["{$codes[$i]}_{$i}"]['IBLOCK_SECTION_ID'] == $lastParent['id']
                )
            ) {
                $lastParent = $sections["{$codes[$i]}_{$i}"];
                $toReturn = $sections["{$codes[$i]}_{$i}"];
                unset($toReturn['IBLOCK_SECTION_ID']);
                $return[] = $toReturn;
            } else {
                break;
            }
        }

        return $return;
    }

    /**
     * Возвращает описание заданного элемента.
     *
     * @param int    $iblock
     * @param string $code
     * @param int    $sectionId
     * @param array  $propertiesToLoad
     */
    protected function getElementByCode($iblock, $code, $sectionId, array $propertiesToLoad = array())
    {
        $return = null;
        $filter = array(
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'IBLOCK_ID' => $iblock,
            'SECTION_ID' => $sectionId ? $sectionId : false,
        );
        if ($code) {
            $filter['CODE'] = $code;
        } else {
            $filter['CODE'] = false;
        }
        $select = array(
            'ID',
            'NAME',
            'CODE',
            'PREVIEW_TEXT',
            'PREVIEW_PICTURE',
            'DETAIL_TEXT',
            'DETAIL_PICTURE',
            'DETAIL_PAGE_URL',
            'IBLOCK_ID',
        );
        foreach ($propertiesToLoad as $prop) {
            $select[] = 'PROPERTY_'.strtoupper($prop);
        }
        $res = \CIBlockElement::GetList(
            array('ID' => 'desc'),
            $filter,
            false,
            false,
            $select
        );
        if ($ob = $res->GetNext()) {
            $return = array(
                'type' => 'element',
                'id' => (int) $ob['ID'],
                'iblock' => (int) $ob['IBLOCK_ID'],
                'name' => $ob['NAME'],
                'code' => $ob['CODE'],
                'url' => $ob['DETAIL_PAGE_URL'],
                'preview_text' => $ob['PREVIEW_TEXT'],
                'preview_picture' => !empty($ob['PREVIEW_PICTURE']) ? \CFile::GetFileArray($ob['PREVIEW_PICTURE']) : null,
                'detail_text' => $ob['DETAIL_TEXT'],
                'detail_picture' => !empty($ob['DETAIL_PICTURE']) ? \CFile::GetFileArray($ob['DETAIL_PICTURE']) : null,
            );
            foreach ($propertiesToLoad as $prop) {
                $key = 'PROPERTY_'.strtoupper($prop).'_VALUE';
                if (!isset($ob[$key])) {
                    continue;
                }
                $description = $ob['PROPERTY_'.strtoupper($prop).'_DESCRIPTION'];
                $isNotEmptyDescription = !empty($description) && array_diff($description, array(''));
                if (is_array($ob[$key]) && $isNotEmptyDescription) {
                    $return[$prop] = array_combine($ob[$key], $ob['PROPERTY_'.strtoupper($prop).'_DESCRIPTION']);
                } else {
                    $return[$prop] = $ob[$key];
                }
            }
        }

        return $return;
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

    /**
     * Возварщает ссылку на текущую страницу.
     *
     * @return string
     */
    protected function getRequestedPage()
    {
        $r = $this->getApplication()->getContext()->getRequest();

        return trim(str_replace('index.php', '', $r->getRequestedPage()), '/\\ ');
    }

    /**
     * Возвращает ссылку на объект приложения битрикса.
     *
     * @return \Bitrix\Main\Application
     */
    protected function getApplication()
    {
        return Application::getInstance();
    }

    /**
     * Проверяет имеет ли пользователь право доступа к данной странице
     *
     * @param string $propertyName
     * @param array $path
     *
     * @return bool
     */
    protected function checkAccess($propertyName, array $path)
    {
        global $USER;
        $return = true;
        if (!empty($propertyName) && !$USER->IsAdmin()) {
            //проверяем доступы начиная с текущей страницы до корня
            $toCheck = array_reverse($path);
            //получаем список групп текущего пользователя
            $arUserGroups = $USER->GetUserGroupArray();
            //получаем список строковых кодов групп
            $arGroupsCodes = $this->getGroupsCodes();
            foreach ($toCheck as $item) {
                //если проверка не требуется, то просто идем дальше
                if (empty($item[$propertyName])) continue;
                $groupsCanAccess = array();
                //проверяем, чтобы пользователь входил хотя бы в одну из групп,
                //указанных в настройках доступа
                foreach ($item[$propertyName] as $group) {
                    if (!isset($arGroupsCodes[$group])) continue;
                    $groupsCanAccess[] = $arGroupsCodes[$group]['ID'];
                }
                if (!array_intersect($groupsCanAccess, $arUserGroups)) {
                    $return = false;
                }
                //если для текущего узла были правила,
                //то в любом случае не идем выше по дереву
                break;
            }
        }
        return $return;
    }

    /**
     * Возвращает список групп вместе с их кодами
     *
     * @return array
     */
    protected function getGroupsCodes()
    {
        $return = array();
        $res = \CGroup::GetList(
            ($by = 'c_sort'),
            ($order = 'desc'),
            array('ACTIVE' => 'Y')
        );
        while ($ob = $res->Fetch()) {
            if (empty($ob['STRING_ID'])) continue;
            $return[$ob['STRING_ID']] = $ob;
        }
        return $return;
    }

    /**
     * Возвращает список сео тегов для элемента.
     *
     * @param int   $iblock
     * @param array $element
     *
     * @return array
     */
    protected function getMeta($iblock, array $element)
    {
        $return = array();
        $iprop = null;
        if ($element['type'] === 'element') {
            $ipropValues = new ElementValues($iblock, $element['id']);
            $iprop = $ipropValues->getValues();
        } elseif ($element['type'] === 'section') {
            $ipropValues = new SectionValues($iblock, $element['id']);
            $iprop = $ipropValues->getValues();
        }
        $return['title'] = !empty($iprop['ELEMENT_META_TITLE'])
            ? $iprop['ELEMENT_META_TITLE']
            : $element['name'];
        $return['keywords'] = !empty($iprop['ELEMENT_META_KEYWORDS'])
            ? $iprop['ELEMENT_META_KEYWORDS']
            : '';
        $return['description'] = !empty($iprop['ELEMENT_META_DESCRIPTION'])
            ? $iprop['ELEMENT_META_DESCRIPTION']
            : '';
        $return['h1'] = !empty($iprop['ELEMENT_PAGE_TITLE'])
            ? $iprop['ELEMENT_PAGE_TITLE']
            : $element['name'];

        return $return;
    }
}
