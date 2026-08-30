<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):
    $page = $APPLICATION->GetCurPage();
    ?>
<div class="menue_fixed ">
    <div class="personal_page_menue">

    <?


    foreach($arResult as $key=>$arItem):
        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
            continue;
    ?>
        <div class="page_menue_slide "><a href="<?=$arItem["LINK"]?>" class="<?if($page==$arItem["LINK"]) echo "activeSlickSlide";?> <?if($arItem["SELECTED"]){echo "selected";}?>" ><?=$arItem["TEXT"]?></a></div>

    <?endforeach?>

    </div>
</div>
<?endif?>