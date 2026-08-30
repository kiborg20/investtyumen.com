<?php

use Bitrix\Main\Loader;
use Bitrix\Main\IO\File;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

//Подключаем автозагрузку классов композера.
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
CModule::AddAutoloadClasses(
    '',
    [
        // вспомогательный класс
        'Cinvestments' => '/local/lib/Cinvestments.php',
    ]
);

if (file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/twig.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/twig.php';
}

autoLoadModules();

/*
    Файл с функциями проекта

if (file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions.php';
}
**/


function autoLoadModules()
{
    $directory = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/includeModules';
    if(file_exists($directory))
    {
        $loadModulesFiles = array_diff(scandir($directory), array('..', '.', '.gitignore'));
        foreach ($loadModulesFiles as $loadModules) {
            $info = new SplFileInfo($loadModules);
            if ($info->getExtension() != 'php') {
                continue;
            }

            require_once $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/includeModules/' . $loadModules;
        }
    }
}