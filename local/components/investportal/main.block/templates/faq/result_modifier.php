<?php

$aTypes = [];

foreach ($arResult['ITEMS'] as $aItem)
{
    $aTypes[$aItem['TYPE']['PROPERTY_VALUE']][] = $aItem;
}

$arResult['TYPES'] = $aTypes;