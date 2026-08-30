<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$i=1;?>
<!--<div class="faq">-->
<?foreach ($arResult as $item): ?>
    <div class="faqitem <?if($i == 1){ echo('faqitemexpanded'); }?>">
        <div class="faqitemtitle"><?=$item["NAME"]?></div>
        <div class="faqitemcontent">
            <?=$item["PREVIEW_TEXT"]?>
        </div>
    </div>
    <?$i++;?>
    <?endforeach;?>
<!--</div>-->
    

 
    

    
    