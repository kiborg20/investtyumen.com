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
                $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 1920,'height' => 1080), BX_RESIZE_IMAGE_EXACT, true);
            ?>

            <div class="photoslidertypeone_img_slide ">
                <div class="photoslidertypeone_img_slide_img">
                    <img src="<?=$file['src']?>" alt="">
                </div>
                <?if($item["PROPERTY_IT_SLIDER2TITLE_VALUE"]){
                  $item["PROPERTY_IT_SLIDER2TITLE_VALUE"];
                
                } else{
                    <div class="textsubtitle">
                <?echo('нет ссылки')?>
                    <?=htmlspecialchars_decode($item["PROPERTY_IT_SLIDER2TITLE_VALUE"]);?>
                    </div>
                }?>
            </div>
            <?endforeach;?>
            
        </div>
    </section>