<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalJS("/local/components/bitrix/slider2/slider2.js");
?>
    <section class="photoslidertypeone" style="margin-bottom:120px;">
        <div class="photoslidertypeone_bg" style="height:100%;"></div>
        <div class="container">
            <h2 class="t1920 ttu" style="letter-spacing:0.02em; width:522px;"><?=htmlspecialchars_decode($arParams['HEROTITLE']);?></h2>
        </div>
        <div class="photoslidertypeone_img">
            <?foreach ($arResult as $item): ?>
            <?
                $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 1920,'height' => 1080), BX_RESIZE_IMAGE_EXACT, true);
            ?>

            <div class="photoslidertypeone_img_slide ">
                <div class="photoslidertypeone_img_slide_img">
                    <img src="<?=$file['src']?>" alt="">
                </div>
                <?if ($item["PROPERTY_IT_SLIDER_LINK_VALUE"]){?>
                    <a style="text-decoration:none;" href="<?=htmlspecialchars_decode($item["PROPERTY_IT_SLIDER_LINK_VALUE"]);?>" class="textsubtitle">
                    <?=htmlspecialchars_decode($item["PROPERTY_IT_SLIDER_TITLE_VALUE"]);?>
                    </a>
                <?} else{?>
                <div style="text-decoration:none;" class="textsubtitle">
                    <?=htmlspecialchars_decode($item["PROPERTY_IT_SLIDER_TITLE_VALUE"]);?>
                    </div>
                <?}?>
            </div>
            <?endforeach;?>
            
        </div>
    </section>