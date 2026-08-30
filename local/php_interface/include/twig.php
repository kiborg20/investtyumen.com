<?php

use Bitrix\Main\EventManager;

global $arCustomTemplateEngines;
$arCustomTemplateEngines['twig'] = [
    'templateExt' => [
        'twig',
    ],
    'function' => 'renderTwig'
];

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('', 'onAfterTwigEngineInit', 'registerTwigFunctions');

function renderTwig(
    $templateFile,
    $arResult,
    $arParams,
    $arLangMessages,
    $templateFolder,
    $parentTemplateFolder,
    $template
)
{
    $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
    $twig = new \Twig\Environment($loader, [
        'cache' => $_SERVER['DOCUMENT_ROOT'].'/bitrix/cache/twig/',
        'auto_reload' => isset($_GET['clear_cache']) && strtoupper($_GET['clear_cache']) == 'Y',
        'debug' => true,
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    registerTwigFunctions($twig);
    //$GLOBALS['twig']->addExtension(new \Twig\Extension\DebugExtension());
    echo $twig->render(
        $templateFile,
        [
            'arResult' => $arResult,
            'arParams' => $arParams,
            'arLangMessages' => $arLangMessages,
            'template' => $template,
            'templateFolder' => $templateFolder,
            'parentTemplateFolder' => $parentTemplateFolder,
        ]
    );
}

function registerTwigFunctions(\Twig\Environment $twig)
{
    $includeComponentFunction = new \Twig\TwigFunction('include_component', function($componentName, $componentTemplate = '', $arParams = [], $parentComponent = null, $arFunctionParams = [], $returnResult = false) {
        global $APPLICATION;
        $APPLICATION->IncludeComponent($componentName, $componentTemplate, $arParams, $parentComponent, $arFunctionParams, $returnResult);
    });
    $twig->addFunction($includeComponentFunction);

    $getSrcById = new \Twig\TwigFunction('get_src_by_id', function($fileId) {
        return CFile::GetPath($fileId);
    });
    $twig->addFunction($getSrcById);
}
