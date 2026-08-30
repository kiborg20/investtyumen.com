<?php

foreach ($arResult['ITEMS'] as $aItem)
{
    $arResult['NUMBERS'][] = $aItem['number']['PROPERTY_VALUE'];
}