<?php
/*
 * Файл bitrix/components/demo/catalog.element/.description.php
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
    'NAME' => 'Блок фото с текстом',
    'DESCRIPTION' => 'Выводит три фотографии и текст и кнопку',
    'PATH' => array(
        'ID' => 'itcomponents',
        'NAME' => 'Компоненты ИнвестТюмень',
        'CHILD' => array(
            'ID' => 'textandphotos',
            'NAME' => 'Кат'
        )
    ),
    'ICON' => '/images/icon.gif'
);