<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<?php

$APPLICATION->IncludeComponent("investportal:creative.menu", "",
    [
        'CODE' => $arResult['current']['code'],
        'IBLOCK_ID' => $arResult['current']['iblock'],
        'ID' => $arResult['current']['id'],
        'PAGE_NAME' => $arResult['current']['name'],
        'DESCRIPTION' => $arResult['current']['detail_text'],
        'MAX_DEPTH_LEVEL' => $arParams['MAX_DEPTH_LEVEL']
    ],
    false);
?>