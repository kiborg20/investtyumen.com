<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    'PARAMETERS' => array(

        'SEF_MODE' => array(),
        'CACHE_TIME' => array('DEFAULT' => 86400),

        'IBLOCK_ID' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_IBLOCK_MENU_IBLOCK_ID'),
            'DEFAULT' => '',
            'PARENT' => 'BASE'
        ),
        'SECTION_ID' => array(
            'NAME' => GetMessage('CREATIVE_FOUNDATION_IBLOCK_MENU_SECTION_ID'),
            'DEFAULT' => '',
            'PARENT' => 'BASE'
        ),

    )
);
