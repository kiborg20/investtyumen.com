<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$r = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if (!$r->isAjaxRequest()) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/*
внимание! данная страница является аналогом входного скрипта
все данные лежат в инфоблоке "Страницы"
все шаблоны лежат внутри шаблона компонента local/templates/.default/components/creative.foundation/content
*/
?>

<?php $APPLICATION->IncludeComponent("creative.foundation:content", "investtumen", Array(
    "COMPONENT_TEMPLATE" => "",
    "SEF_MODE" => "Y",	// Включить поддержку ЧПУ
    "SEF_FOLDER" => "/",	// Каталог ЧПУ (относительно корня сайта)
    "IBLOCK_ID" => "structure",	// ID или код инфоблока
    "TEMPLATE_PROPERTY" => "template",	// Свойство инфоблока, в котором хранится шаблон
    "COMPLEX_PAGE_PROPERTY" => "is_complex",	// Свойство инфоблока, в котором указывается, что на странице комплексный компонент
    "PARAM_PROPERTY" => "",	// Свойство инфоблока, в котором хранятся параметры страницы
    "PAGE_404" => "/404.php",	// Путь до страницы с ошибкой 404
    "SET_META" => "Y",	// Устанавливать мета-заголовки
    "SET_BREADCRUMBS" => "Y",	// Устанавливать хлебные крошки
    "CACHE_TYPE" => "A",	// Тип кеширования
    "CACHE_TIME" => "86400",	// Время кеширования (сек.)
),
    false
);

if (!$r->isAjaxRequest()) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
