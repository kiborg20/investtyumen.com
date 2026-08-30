<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

$prevActive = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" stroke="#4A66F5" d="M13.651 7.707a.25.25 0 1 0-.354-.354l-4.469 4.47a.25.25 0 0 0 0 .354l4.823-4.47Zm0 0-3.939 3.94-.354.353m4.293-4.293L9.358 12m0 0 .354.354M9.358 12l.354.354m0 0 3.94 3.939m-3.94-3.94 3.94 3.94m0 0a.25.25 0 0 1 0 .354v-.354Zm-.354.354-4.47-4.47 4.823 4.47a.25.25 0 0 1-.353 0Z"/></svg>';
$prevInactive = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" stroke="#252830" d="M13.651 7.707a.25.25 0 1 0-.354-.354l-4.469 4.47a.25.25 0 0 0 0 .354l4.823-4.47Zm0 0-3.939 3.94-.354.353m4.293-4.293L9.358 12m0 0 .354.354M9.358 12l.354.354m0 0 3.94 3.939m-3.94-3.94 3.94 3.94m0 0a.25.25 0 0 1 0 .354v-.354Zm-.354.354-4.47-4.47 4.823 4.47a.25.25 0 0 1-.353 0Z"/></svg>';

$nextActive = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" stroke="#4A66F5" d="m14.656 12-.353.354-3.94 3.939a.25.25 0 0 0 0 .354M14.656 12l-3.586 5a.75.75 0 0 1-1.06 0l.353-.353M14.656 12l-.353-.353m.353.353-.353-.353m-3.94 5a.25.25 0 0 0 .354 0m-.354 0h.354m0 0 .353.353-.353-.354Zm0 0 4.47-4.47m-4.47 4.47 4.47-4.47m-.884-.53-3.94-3.94-.352.353.352-.353m3.94 3.94-3.94-3.94m5.177 3.763-.354.353-4.47-4.47a.25.25 0 0 0-.353 0m5.177 4.117-5.53-3.41a.75.75 0 0 1 0-1.06l.353.354m5.177 4.116-.354.353a.25.25 0 0 1 0 .354m.354-.707-.354.707m-4.823-4.823a.25.25 0 0 0 0 .353m0-.353v.353"/></svg>';
$nextInactive = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" stroke="#252830" d="m14.656 12-.353.354-3.94 3.939a.25.25 0 0 0 0 .354M14.656 12l-3.586 5a.75.75 0 0 1-1.06 0l.353-.353M14.656 12l-.353-.353m.353.353-.353-.353m-3.94 5a.25.25 0 0 0 .354 0m-.354 0h.354m0 0 .353.353-.353-.354Zm0 0 4.47-4.47m-4.47 4.47 4.47-4.47m-.884-.53-3.94-3.94-.352.353.352-.353m3.94 3.94-3.94-3.94m5.177 3.763-.354.353-4.47-4.47a.25.25 0 0 0-.353 0m5.177 4.117-5.53-3.41a.75.75 0 0 1 0-1.06l.353.354m5.177 4.116-.354.353a.25.25 0 0 1 0 .354m.354-.707-.354.707m-4.823-4.823a.25.25 0 0 0 0 .353m0-.353v.353"/></svg>';

?>
<div class="pagination">

    <?if($arResult["bDescPageNumbering"] === true):?>

        <div class="pagination__item">
            <?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
                <?if($arResult["bSavePage"]):?>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=$prevActive ?></a>
                <?else:?>
                    <?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$prevActive ?></a>
                    <?else:?>
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=$prevActive ?></a>
                    <?endif?>
                <?endif?>
            <?else:?>
                <?=$prevInactive ?>
            <?endif?>
        </div>

        <div class="pagination__item">
            <?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
                <?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

                <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <span class="pagination__link pagination__link_current"><?=$NavRecordGroupPrint?></span>
                <?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
                    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
                <?else:?>
                    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
                <?endif?>

                <?$arResult["nStartPage"]--?>
            <?endwhile?>
        </div>

        <div class="pagination__item">
            <?if ($arResult["NavPageNomer"] > 1):?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=$nextActive ?></a>
            <?else:?>
                <?=$nextInactive ?>
            <?endif?>
        </div>

    <?else:?>

        <div class="pagination__item">
            <?if ($arResult["NavPageNomer"] > 1):?>

                <?if($arResult["bSavePage"]):?>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=$prevActive ?></a>
                <?else:?>
                    <?if ($arResult["NavPageNomer"] > 2):?>
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=$prevActive ?></a>
                    <?else:?>
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$prevActive ?></a>
                    <?endif?>
                <?endif?>

            <?else:?>
                <?=$prevInactive ?>
            <?endif?>
        </div>

        <div class="pagination__item">
            <?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

                <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <span class="pagination__link pagination__link_current"><?=$arResult["nStartPage"]?></span>
                <?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
                    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
                <?else:?>
                    <a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
                <?endif?>
                <?$arResult["nStartPage"]++?>
            <?endwhile?>
        </div>

        <div class="pagination__item">
            <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=$nextActive ?></a>
            <?else:?>
                <?=$nextInactive ?>
            <?endif?>
        </div>

    <?endif?>


    <?if ($arResult["bShowAll"]):?>
    <noindex>
        <?if ($arResult["NavShowAll"]):?>
            |&nbsp;<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" rel="nofollow"><?=GetMessage("nav_paged")?></a>
        <?else:?>
            |&nbsp;<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" rel="nofollow"><?=GetMessage("nav_all")?></a>
        <?endif?>
    </noindex>
    <?endif?>

</div>
