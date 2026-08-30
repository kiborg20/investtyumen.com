<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$APPLICATION->IncludeComponent('investportal:complex', '',
    [
        'PAGE_TYPE' => 'list',
        'CODE' => $arParams['CURRENT_CODE'],
        'NEWS_COUNT' => $arParams['NEWS_COUNT'],
        'FILTER_PROPERTY_CODE' => $arParams['FILTER_PROPERTY_CODE'],
        'USE_FILTER' => $arParams['USE_FILTER'],
        'IBLOCK_LIST' => $arParams['IBLOCK_LIST'],
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'TEMPLATE' => $arParams['TEMPLATE'],
    ]);
?>


