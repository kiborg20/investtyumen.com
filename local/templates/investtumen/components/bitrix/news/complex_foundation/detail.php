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
?>

<? $APPLICATION->IncludeComponent('investportal:complex', '',
    [
        'PAGE_TYPE' => 'detail',
        'CODE' => $arParams['CURRENT_CODE'],
        'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'DETAIL_TEMPLATE' => $arParams['DETAIL_TEMPLATE']
    ]);
?>
