<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
    <section class="informres bgblue">
        <div class="container">
            <div class="titlebold fontwhite"><?=$arParams['HEROTITLE'];?></div>
            <div class="infresource">
            <?foreach ($arResult as $item): ?>
            <?
            // $file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
              $img = CFile::GetPath($item["PREVIEW_PICTURE"]);
            ?>
            
            <a href="<?=htmlspecialchars_decode($item["PROPERTY_IT_EXT_LINK_VALUE"])?>" class="linkpic" target="blanc_"><img src="<?=$img?>" alt=""><?=$item["NAME"]?></a>
            <?endforeach;?>
            </div>
        </div>
    </section>
    