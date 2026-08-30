<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    'PARAMETERS' => array(

        'SEF_MODE' => array(),
        'CACHE_TIME' => array('DEFAULT' => 86400),

        'IBLOCK_ID' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_CONTENT_IBLOCK_ID'),
            'DEFAULT' => '',
            'PARENT' => 'BASE'
        ),
        'TEMPLATE_PROPERTY' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_TEMPLATE_PROPERTY'),
            'DEFAULT' => 'template',
            'PARENT' => 'BASE'
        ),
        'PARAM_PROPERTY' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_PARAM_PROPERTY'),
            'DEFAULT' => '',
            'PARENT' => 'BASE'
        ),
        'COMPLEX_PAGE_PROPERTY' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_COMPLEX_PAGE_PROPERTY'),
            'DEFAULT' => '',
            'PARENT' => 'BASE'
        ),
        'URL' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_URL'),
            'DEFAULT' => '',
            'PARENT' => 'BASE'
        ),
        'PAGE_404' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_PAGE_404'),
            'DEFAULT' => '/404.php',
            'PARENT' => 'BASE'
        ),
        'SET_META' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_SET_META'),
            'PARENT' => 'BASE',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
        'SET_BREADCRUMBS' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_SET_BREADCRUMBS'),
            'PARENT' => 'BASE',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),

    )
);
