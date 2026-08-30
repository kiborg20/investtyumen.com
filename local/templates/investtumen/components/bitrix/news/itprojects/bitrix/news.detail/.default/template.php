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
$iblockID = 15;
$arSelect = Array('ID', 'NAME', 'DETAIL_PAGE_URL', 'DATE_ACTIVE_FROM', 'PREVIEW_TEXT');
$arFilter = Array("IBLOCK_ID" => IntVal($iblockID), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array('nTopCount' => 3), $arSelect);
while($arFields2 = $res->GetNext())
{
    $arResult2[] = $arFields2;    
}
?>

<section>
    <div class="container newssection">
        <div class="newssidebar">
            <?foreach ($arResult2 as $item): ?>
                <div class="topcard_slide_text">
                    
                    <div class="news_slider_text"><?=$item["NAME"]?></div>
                    <a href="/projects<?=$item["DETAIL_PAGE_URL"]?>" class="news_slider_link" tabindex="0">о проекте</a>
                </div>
            <?endforeach;?>
        </div>
        <div class="newsright">
            <div class="breadscrumbs"><a href="/">Главная</a> / <a href=""><?=$arResult["NAME"]?></a></div>
            <div class="newscontent">
                <h1><?=$arResult["NAME"]?></h1>
                
                <div class="news body">
                    <?=$arResult["DETAIL_TEXT"]?>
                </div>
            </div>
        </div>
    </div>
</section>