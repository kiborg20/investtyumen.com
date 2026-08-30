<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => GetMessage('CREATIVE_FOUNDATION_CONTENT'),
	'DESCRIPTION' => GetMessage('CREATIVE_FOUNDATION_CONTENT'),
	'SORT' => 320,
	'COMPLEX' => 'N',
	'PATH' => array(
		'ID' => 'stroitel',
		'NAME' => GetMessage('CREATIVE_FOUNDATION'),
		'CHILD' => array(
			'ID' => 'content',
			'NAME' => GetMessage('CREATIVE_FOUNDATION_CONTENT')
		)
	),
);
