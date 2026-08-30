<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$key = array_search('WORK_COMPANY' , $arResult['SHOW_FIELDS']);

unset($arResult['SHOW_FIELDS'][$key]);

array_unshift($arResult['SHOW_FIELDS'] , 'WORK_COMPANY');