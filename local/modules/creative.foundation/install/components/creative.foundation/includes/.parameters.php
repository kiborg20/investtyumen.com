<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	'PARAMETERS' => array(

		'CACHE_TIME' => array('DEFAULT' => 86400),

		'IBLOCK_ID' => array(
			'NAME' => GetMessage('CREATIVE_FOUNDATION_CONTENT_IBLOCK_ID'),
			'DEFAULT' => '',
			'PARENT' => 'BASE'
		),
		'CODE' => array(
			'NAME' => GetMessage('CREATIVE_FOUNDATION_CODE'),
			'DEFAULT' => '',
			'PARENT' => 'BASE'
		),

	)
);
