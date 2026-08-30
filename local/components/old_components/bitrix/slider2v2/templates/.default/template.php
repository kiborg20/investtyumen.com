<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
    <section class="photoslidertypeone">
        <div class="photoslidertypeone_bg"></div>
        <div class="container">
            <h2 class=""><?=$arParams['HEROTITLE'];?></h2>
        </div>
        <div class="photoslidertypeone_img">
            <?foreach ($arResult as $item): ?>
            <?
                $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 1164,'height' => 689), BX_RESIZE_IMAGE_EXACT, true);
            ?>
            <div class="photoslidertypeone_img_slide ">
                <div class="photoslidertypeone_img_slide_img">
                    <img src="<?=$file['src']?>" alt="">
                </div>
                <div class="textsubtitle">
                    <?=htmlspecialchars_decode($item["PROPERTY_IT_SLIDER_T_VALUE"]["TEXT"])?>
                </div>
            </div>
            <?endforeach;?>
            
        </div>
    </section>