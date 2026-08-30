<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs("https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js");

if (!Loader::includeModule("iblock")) {
    return;
}

if (!$arParams['IBLOCK_ID'] && $arParams['IBLOCK_CODE']) {
    $arParams['IBLOCK_ID'] = \Tyumip\Main\Helper\Helper::getIblockId($arParams['IBLOCK_CODE']);
}
$properties = [];
foreach ($arParams["PROPERTY_CODE"] as $prop) {
    $properties[] = "PROPERTY_" . $prop;
}

$count = $arParams["ITEMS_COUNT"] ?: 6;
$arSelect = array_merge(["ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTIES"], $properties);
$arFilter = ["IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "ACTIVE" => "Y"];
$res = CIBlockElement::GetList(['SORT' => 'asc'], $arFilter, false, ['nTopCount' => $count], $arSelect);
while ($arFields = $res->GetNext()) {
    if ($arFields['PREVIEW_PICTURE']) {
        $arFields['PREVIEW_PICTURE'] = CFile::GetPath($arFields['PREVIEW_PICTURE']);

    }
    $arResult[] = $arFields;
}

$this->includeComponentTemplate();
?>