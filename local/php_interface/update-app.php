<?php

$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__DIR__)) . '/..';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

const NAME = 'sprint.migration';

$return = '';

if (!($module = CModule::CreateModuleObject(NAME))) {
    $return .=  "Module sprint.migration not found" . "\n";
} elseif ($module->IsInstalled()) {
    $return .= "Module sprint.migration already installed" . "\n";
} else {
    $module->DoInstall();
    $return .= "Module sprint.migration installed" . "\n";
}

//Проверяем установлен ли creative.fondation
if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/components/creative.foundation")) {
    if (!($module = CModule::CreateModuleObject('creative.foundation'))) {
        $return .=  "Module creative.foundation not found" . "\n";
    } elseif ($module->IsInstalled()) {
        $module->DoUninstall();
        $module->DoInstall();
        $return .= "Module creative.foundation re_installed" . "\n";
    } else {
        $module->DoUninstall();
        $return .= "Module creative.foundation installed" . "\n";
    }
}

//Проверяем установлен ли tyumip.main
if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/includeModules/tyumip.main.php")) {
    if (!($module = CModule::CreateModuleObject('tyumip.main'))) {
        $return .=  "Module tyumip.main not found" . "\n";
    } elseif ($module->IsInstalled()) {
        $module->DoUninstall();
        $module->DoInstall();
        $return .= "Module tyumip.main re_installed" . "\n";
    } else {
        $module->DoUninstall();
        $return .= "Module tyumip.main installed" . "\n";
    }
}



echo $return . "\n";

exit(0);