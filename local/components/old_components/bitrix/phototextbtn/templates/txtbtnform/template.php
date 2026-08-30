<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="onmain photoswithtextv2">
    <div class="container">
        <div class="dadflex">
            <?if ($arParams["TYPEPHOTO"] == '1F2'){?>
                <div class="photoswithtextv2col">
                    <div class="photoswithtextv2img">
                        <div class="photoswithtextv2img_big" style="background-image: url('<?=$arParams["PIC1"];?>');"></div>
                    </div>
                </div>
                <div class="photoswithtextv2col">
                    <div class="photoswithtextv2img">
                        <div class="photoswithtextv2img_middle" style="background: url('<?=$arParams["PIC2"];?>');"></div>    
                    </div>
                    <div class="photoswithtextv2img">
                        <div class="photoswithtextv2img_small" style="background: url('<?=$arParams["PIC3"];?>')"></div>
                    </div>
                </div>
            <?} else {?>
                <div class="photoswithtextv2col">
                    <div class="photoswithtextv2img">
                        <div class="photoswithtextv2img_middle" style="background: url('<?=$arParams["PIC1"];?>');"></div>    
                    </div>
                    <div class="photoswithtextv2img">
                        <div class="photoswithtextv2img_small" style="background-image: url('<?=$arParams["PIC2"];?>');"></div>
                    </div>
                </div>
                <div class="photoswithtextv2col">
                    <div class="photoswithtextv2img">
                        <div class="photoswithtextv2img_big" style="background: url('<?=$arParams["PIC3"];?>')"></div>
                    </div>
                </div>
            <?};?>
            <div class="photoswithtextv2col">
                <?if ($arParams["TITLE"]){?><div class="textsubtitle"><?=htmlspecialchars_decode($arParams["TITLE"]);?></div><?}?>
                <?if ($arParams["TEXT"]){?><p><?=htmlspecialchars_decode($arParams["TEXT"]);?></p><?}?>
                <a href="<?=$arParams["LINK"];?>" class="btn forminvest" target=""><?=htmlspecialchars_decode($arParams["LINKTITLE"]);?></a>
            </div>
        </div>
    </div>
</section>