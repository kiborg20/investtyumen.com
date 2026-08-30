<?php
$arUrlRewrite=array (
  2 => 
  array (
    'CONDITION' => '#^/api/#',
    'PATH' => '/api/index.php',
    'SORT' => 1,
  ),
  0 => 
  array (
    'CONDITION' => '#^/projects/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/projects/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/topstory/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/topstory/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'creative.foundation:content',
    'PATH' => '/index.php',
    'SORT' => 100,
  ),
);
