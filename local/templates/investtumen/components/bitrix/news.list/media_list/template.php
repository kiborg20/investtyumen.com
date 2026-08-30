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
            Медиагалерея
        </p>
        <div class="mediaslider">
            <div class="mediaslider_slide">
                <div class="dadflex">
                    <?foreach($arResult["ITEMS"] as $arItems):?>
                        <? foreach ($arItems as $arItem):?>
                            <div class="mediaitem mediaitemvideo" data-video="<?=$arItem['ID']?>" style="background: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>') no-repeat;">
                                <div class="mediaitemcont">
                                    <div class="mediaitemtitle">
                                        <?=$arItem['NAME']?>
                                    </div>
                                </div>
                            </div>
                        <?endforeach;?>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </div>
</section>
<?foreach($arResult["ITEMS"] as $arItems):?>
    <? foreach ($arItems as $arItem):?>
        <div class="fixed-overlay fixed-overlay__modal" data-video="<?=$arItem['ID']?>">
            <div class="modal ">
                <div class="modal_container" style="padding: 37px 40px 40px 40px;">
                    <div class="modalclose"></div>
                    <div class="">
                        <video src="<?=$arItem['DISPLAY_PROPERTIES']['IT_MEDIA_FILE']['FILE_VALUE']['SRC']?>" controls></video>
                    </div>
                </div>
            </div>
        </div>
    <?endforeach;?>
<?endforeach;?>