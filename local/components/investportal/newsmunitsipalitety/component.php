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

$ids = [];
if (is_countable($arParams['LINK_NEWS']) && count($arParams['LINK_NEWS']) > 0) {
    foreach ($arParams['LINK_NEWS'] as $key => $value) {
        $ids[] = $value['PROPERTY_VALUE']['ID'];
    }
}

$arSelect = ["ID", "NAME", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "PROPERTIES", "PROPERTY_" . $arParams["PROPERTY_CODE"], "PROPERTY_IT_EXT_NAMELINK", "PROPERTY_IT_EXT_LINK", "PROPERTY_IT_EXT_NAMELINK_EN"];
$arFilter = ["IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]), "ACTIVE" => "Y", "ID" => $ids];
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
