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
        <p class="t1920 ttu">
            ИСТОРИИ УСПЕХА
        </p>
        <div class="mediaslider">
            <div class="mediaslider_slide">
                <div class="dadflex">
                    <?foreach($arResult["ITEMS"] as $arItem):?>
                    <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="mediaitem mediaitemvideo" style="background: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>') no-repeat;">
                        <div class="mediaitemcont">
                            <div class="mediaitemtitle">
                            <?echo $arItem["NAME"]?>
                            </div>
                        </div>
                        <div class="medbg"></div>
                    </a>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </div>
 </section> 