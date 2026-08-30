<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$i=1;?>
<div class="project_slider">
<?foreach ($arResult as $item): ?>
    <?
        $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 1235,'height' => 695), BX_RESIZE_IMAGE_EXACT, true);
    ?>
    <a href="/projects<?=$item["DETAIL_PAGE_URL"]?>" class="project_slide prtabact" data-target="prtabmodal<?=$item["ID"]?>" style="background: url('<?=$file['src']?>') no-repeat;background-position: center;background-size: cover;">
        <div class="project_slide_content">
            <div class="project_title"><?=$item["NAME"]?></div>
            <div class="project_text">
                <?=$item["PREVIEW_TEXT"]?>
            </div>
        </div>
    </a>
    <?$i++;?>
    <?endforeach;?>
</div>
<div class="prmobmain">
<?foreach ($arResult as $item): ?>
    <?
        $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 1235,'height' => 695), BX_RESIZE_IMAGE_EXACT, true);
    ?>
    <a href="/projects<?=$item["DETAIL_PAGE_URL"]?>" class="project_slide prtabact" data-target="prtabmodal<?=$item["ID"]?>" style="background: url('<?=$file['src']?>') no-repeat;background-position: center;background-size: cover;">
        <div class="project_slide_content">
            <div class="project_title"><?=$item["NAME"]?></div>
        </div>
    </a>
    <?$i++;?>
    <?endforeach;?>
</div>

<?foreach ($arResult as $item):

    $file2 = CFile::ResizeImageGet($item["DETAIL_PICTURE"], array('width' => 1100,'height' => 619), BX_RESIZE_IMAGE_EXACT, true);?>
<div class="fixed-overlay fixed-overlay__modal prtabmodal prtabmodal<?=$item["ID"]?>">
    <div class="modal">
        <div class="modal_container" >
            <div class="modalclose"></div>
            <div class="investbody">
                <img src="<?=$file2['src'];?>" width="100%" alt="<?=$item["NAME"]?>">
            </div>

        </div>
    </div>
</div>
<?endforeach;?>
