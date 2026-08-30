<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule("iblock")) {
    return;
}
$intCountNews = false;
if ($arParams['COUNT']) {
    $intCountNews['nTopCount'] = $arParams['COUNT'];
}
$arSelect = ["ID", "NAME", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_" . $arParams["PROPERTY_CODE"], "PROPERTY_IT_EXT_NAMELINK", "PROPERTY_IT_EXT_LINK", "PROPERTY_IT_EXT_NAMELINK_EN"];
$arFilter = ["IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "SECTION_ID" => IntVal($arParams["SECTION_ID"]), "ACTIVE" => "Y", "PROPERTY_" . $arParams["PROPERTY_CODE"] . "_VALUE" => 'Да'];
$res = CIBlockElement::GetList(
    [
        'ACTIVE_FROM' => 'DESC'
    ],
    $arFilter,
    false,
    $intCountNews,
    $arSelect
);

while ($arFields = $res->GetNext()) {
    if($arFields['PREVIEW_PICTURE']) {
        $arFields['PREVIEW_PICTURE'] = CFile::GetPath($arFields['PREVIEW_PICTURE']);
    }
    $arResult[] = $arFields;
}

$this->includeComponentTemplate();
