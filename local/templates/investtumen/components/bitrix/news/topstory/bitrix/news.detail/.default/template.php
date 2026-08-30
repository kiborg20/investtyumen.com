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
?>

<?
$iblockID = 14;
$arSelect = Array('ID', 'NAME', 'DETAIL_PAGE_URL', 'DATE_ACTIVE_FROM', 'PREVIEW_TEXT','PROPERTY_IT_STOR_SUB','PROPERTY_IT_STOR_DOL','PROPERTY_IT_STOR_DOL_EN','PROPERTY_IT_STOR_FIO','PROPERTY_IT_STOR_FIO_EN','PROPERTY_IT_STOR_SUB_EN',);
$arFilter = Array("IBLOCK_ID" => IntVal($iblockID), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array('nTopCount' => 5), $arSelect);
while($arFields2 = $res->GetNext())
{
    $arResult2[] = $arFields2;    
}
?>
<section>
    <div class="container newssection">
        <div class="newssidebar topside">
            <?foreach ($arResult2 as $item): ?>

                <div class="topcard_slide_text">
                    <div class="news_slider_text"><?=$item["NAME"]?></div>
                    <div class="news_slider_text"><b class="accent"><?=$item["PROPERTY_IT_STOR_FIO_VALUE"]?></b></div>
                    <a href="/topstory<?=$item["DETAIL_PAGE_URL"]?>" class="news_slider_link" tabindex="0">читать далее</a>
                </div>
            <?endforeach;?>
        </div>
        <div class="newsright">
            <div class="breadscrumbs"><a href="/">Главная</a> / <a href="/preimushchestvato">Преимущества</a> / <a href="/preimushchestvato/?totab=content_ul_tab1">Люди - главная ценность</a> / <a href="/topstory">Истории успеха</a> / <a href=""><?=$arResult["NAME"]?></a></div>
            <div class="newscontent">
                <p class="textsubtitle" style="text-transform:initial;"><?=htmlspecialchars_decode($arResult['PROPERTIES']['IT_STOR_SUB']['VALUE']);?></p>
                
                <h1 class="accent ttu"><?=$arResult['PROPERTIES']['IT_STOR_FIO']['VALUE']?></h1>
                <p class="subh1"><?=htmlspecialchars_decode($arResult['PROPERTIES']['IT_STOR_DOL']['VALUE']);?></p>
                <!-- <span class="newsdate"><?/*=FormatDateFromDB($item["DATE_ACTIVE_FROM"], 'DD.MM.YYYY')*/?></span> -->
                <div class="news_body">
                    <?=$arResult["DETAIL_TEXT"]?>
                </div>
            </div>
        </div>
    </div>
</section>