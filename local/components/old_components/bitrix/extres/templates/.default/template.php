<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div>
    
    <?foreach ($arResult as $item): ?>
            <?
            $file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
              $img = CFile::GetPath($item["PREVIEW_PICTURE"]);
            ?>
            
            
            
    <div class="card_rtl">
        <div class="card_rtl_content">
            <p class="title1 ttu accent mt0"><?=$item["NAME"]?></p>
            <p><?=$item["PREVIEW_TEXT"]?></p>
            <a href="<?=$item["PROPERTY_IT_EXT_LINK_VALUE"]?>" target="blank_" class="linkout <?if ($item["PROPERTY_IT_YESFORM_VALUE"] == 'Да'){?> forminvest <?}?>ttu accent"><?=$item["PROPERTY_IT_EXT_NAMELINK_VALUE"]?></a>
        </div>
    </div>
    <?endforeach;?>
</div>
    
    