<?php

use Tyumip\Main\Service\RequestService;

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$r = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if (!$r->isAjaxRequest()) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION;

if ($r->isEmpty()) {
    return Tyumip\Main\Service\RequestService::prepareAnswer(null, 404);
}

$oRequestService = new RequestService();
?>

<?php
if (!$r->isAjaxRequest()) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
