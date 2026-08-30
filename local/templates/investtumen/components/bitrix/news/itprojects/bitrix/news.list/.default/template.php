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



<section>
    <div class="container">
        <div style="margin:50px 0;" class="titlewithline">ИНВЕСТИЦИОННЫЕ ПРОЕКТЫ</div>
        <div class="newswrapper">
            <?foreach($arResult["ITEMS"] as $arItem):?>
            <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="newsitm">
                <div class="newsitmimg" style="background: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>') no-repeat;"></div>
                <div class="bgover"></div>
                <div class="newsitmc">
                    <p class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></p>
                    <p class="ttu"><?echo $arItem["NAME"]?></p>
                </div>
            </a>
            <?endforeach;?>
            
           <div class="clearfix"></div>
        </div>
    </div>
</section>
