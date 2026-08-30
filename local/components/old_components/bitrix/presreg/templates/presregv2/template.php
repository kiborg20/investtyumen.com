<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="infresource infresourcev2 dadflex">
    <?foreach ($arResult as $item):
    $file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
    $img = CFile::GetPath($item["PREVIEW_PICTURE"]);?>
        <a href="<?=$file?>" class="linkpic" target="blanc_"><img src="<?=$img?>" alt=""><?=$item["NAME"]?></a>
    <?endforeach;?>
</div>
    