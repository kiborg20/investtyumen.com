<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="plitka2">
<?foreach ($arResult as $item): ?>
    <?$file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 448,'height' => 448), BX_RESIZE_IMAGE_EXACT, true);?>
    <a href="/topstory<?=$item["DETAIL_PAGE_URL"]?>" class="plitka2pic" style="background: url('<?=$file['src']?>')no-repeat; background-size: cover;">
        <p class="plitka2title"><?=$item["NAME"];?></p>
    </a>
    <?endforeach;?>
    <div class="clearfix"></div>
</div>