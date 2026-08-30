<?php
//TODO:: NEED REFACTORING (DELETE COMPONENT)
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

if (!Loader::includeModule("iblock")) {
    return;
}
/**
 * @var array $arParams
 * @var array $arResult
 */
$arSelect = ["ID", "NAME", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "PROPERTIES",
    "PROPERTY_" . $arParams["PROPERTY_CODE"], "PROPERTY_BRANCH", "PROPERTY_ICON",
    "PROPERTY_IT_IP_TARGET", "PROPERTY_IT_IP_TARGET", "PROPERTY_IT_IP_VOL", "PROPERTY_IT_IP_EQ", "PROPERTY_IT_IP_LOC", "PROPERTY_IT_IP_FILE", "PROPERTY_IT_IP_TARGET_EN", "PROPERTY_IT_IP_VOL_EN", "PROPERTY_IT_IP_EQ_EN", "PROPERTY_IT_IP_LO_ENC", "PROPERTY_IT_IP_FILE_EN", "PROPERTY_IT_IP_SUM_FIRST", "PROPERTY_IT_IP_PAYBACK", "PROPERTY_IT_IP_PROFIT"];

$arFilter = [
    "IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]),
    "SECTION_ID" => IntVal($arParams["SECTION_ID"]),
    "ACTIVE" => "Y",
    "PROPERTY_" . $arParams["PROPERTY_CODE"] . "_VALUE" => 'Да'
] + (!empty($arParams['BRANCH']) ? ["=PROPERTY_BRANCH_VALUE" => $arParams['BRANCH'] ] : [])
  + (!empty($arParams['IDS']) ? ["=ID" => $arParams['IDS'] ] : []);
$count = $arParams["ITEMS_COUNT"] ? ['nTopCount' => $arParams["ITEMS_COUNT"]] : false;

$res = CIBlockElement::GetList([], $arFilter, false, $count, $arSelect);
while ($arFields = $res->GetNext()) {
    if (isset($arFields['PROPERTY_ICON_VALUE'])) {
        $arFields['PROPERTY_ICON_VALUE'] = \Bitrix\Main\IO\File::getFileContents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($arFields['PROPERTY_ICON_VALUE']));
    }

    $arFields["PREVIEW_PICTURE"] = CFile::ResizeImageGet(
        $arFields["PREVIEW_PICTURE"],
        ['width' => 420, 'height' => 149],
        BX_RESIZE_IMAGE_EXACT,
        true);

    $arResult[] = $arFields;
}

$this->includeComponentTemplate();
?>
