<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
    return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
    $strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}

$strReturn .= '<div class="breadscrumbs__links">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if($arResult[$index]["LINK"] !== "" && $index !== $itemSize - 1)
    {
        $strReturn .= '
                <a class="breadscrumbs__item" href="' . $arResult[$index]["LINK"] . '">' . $title . '</a>
                <span class="breadscrumbs__item">/</span>';
    }
    else if ($index < $itemSize - 1) {
        $strReturn .= '<span style="color: #919191;" class="breadscrumbs__item">' . $title . ' </span>' . '<span class="breadscrumbs__item">/</span>';
    }
    else
    {
        $strReturn .= '<span class="breadscrumbs__item">' . $title . ' </span>';
    }
}

$strReturn .= '</div>';

return $strReturn;
