<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
if(count($arResult["SECTIONS"]) > 0): ?>
    <div class="tyumen-banners">
        <?php foreach ($arResult["SECTIONS"] as $arSection): ?>
            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="tyumen-banners-item">
                <img src="<?=$arSection["PICTURE"]["SRC"]?>" alt="<?=$arSection["NAME"]?>">
                <span class="section-name"><?=$arSection["NAME"]?></span>
                <span class="section-description"><?=$arSection["DESCRIPTION"]?></span>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>