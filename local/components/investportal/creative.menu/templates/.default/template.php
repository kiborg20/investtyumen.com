<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle($arParams['PAGE_NAME']);
?>

<section class="section">
    <div class="wrapper wrapper_mode-l">
        <div class="breadscrumbs">
            <div class="breadscrumbs__button">
                <a onclick="history.back()" href="#">
                    <span class="button button_theme-transparent button_size-s button_padding-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" stroke="#4A66F5" d="M13.651 7.707a.25.25 0 1 0-.354-.354l-4.469 4.47a.25.25 0 0 0 0 .354l4.823-4.47Zm0 0-3.939 3.94-.354.353m4.293-4.293L9.358 12m0 0 .354.354M9.358 12l.354.354m0 0 3.94 3.939m-3.94-3.94 3.94 3.94m0 0a.25.25 0 0 1 0 .354v-.354Zm-.354.354-4.47-4.47 4.823 4.47a.25.25 0 0 1-.353 0Z"/></svg></span>
                    Назад
                </a>
            </div>

            <?php
                $APPLICATION->IncludeComponent("bitrix:breadcrumb", "",
                    [
                        'START_FROM'=> 2,
                        ''
                    ], false);
            ?>
        </div>
    </div>
</section>

<section class="section section_padding-xl">
    <div class="wrapper wrapper_mode-l">
        <div class="block__limited-width-m no-margin">
            <h1 class="headline headline_size-h1"><?=$APPLICATION->ShowTitle(false); ?></h1>
            <div class="description description_size-p1 description_padding-bottom-none">
               <?= $arParams['DESCRIPTION'] ?>
            </div>
        </div>
    </div>
</section>

<?php if ($arResult['NAV_ITEMS']['MAX_DEPTH_LEVEL'] > 1) { ?>
        <?php foreach ($arResult['NAV_ITEMS'][1]['SECTIONS'] as $aSection) { ?>
            <section class="section section_padding-xl">
                <div class="wrapper wrapper_mode-l">
                    <h2 class="headline headline_size-h2"><?=$aSection['DEPTH']?></h2>
                    <div class="card-items card-items__3-column">
                    <?php foreach ($aSection['ITEMS'] as $aItem) { ?>
                        <a href="/<?=$aItem['URL']?>" class="card-items__item card-items__item_hovered">
                            <div class="card-header">
                                <div class="icon-block">
                                    <?=$aItem['ICON']?>
                                </div>

                                <div class="more-link">
                                    <span>Подробнее</span>
                                    <span class="more-link__icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.143 3H13m0 0v7.857M13 3 3 13"/></svg></span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="headline headline_size-h5"><p><?=$aItem['NAME']?></p></div>
                                <div class="description description_size-p2 description_padding-bottom-none description_padding-top-s">
                                    <?=empty($aItem['DESCRIPTION']) ? '' : $aItem['DESCRIPTION']?></div>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                </div>
            </section>
        <?php } ?>
<?php } else {?>
    <section class="section section_padding-xl">
        <div class="wrapper wrapper_mode-l">
            <h2 class="headline headline_size-h2"><?=$arResult['PAGE_TAG'] ?? 'Преимущества'?></h2>
            <div class="card-items card-items__3-column">
                <?php foreach ($arResult['NAV_ITEMS'][1]['ITEMS'] as $aItem) { ?>
                    <a href="/<?=$aItem['URL']?>" class="card-items__item card-items__item_hovered">
                        <div class="card-header">
                            <div class="icon-block">
                                <?=$aItem['ICON']?>
                            </div>

                            <div class="more-link">
                                <span>Подробнее</span>
                                <span class="more-link__icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.143 3H13m0 0v7.857M13 3 3 13"/></svg></span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="headline headline_size-h5"><p><?=$aItem['NAME']?></p></div>
                            <div class="description description_size-p2 description_padding-bottom-none description_padding-top-s">
                                <?=empty($aItem['DESCRIPTION']) ? '' : $aItem['DESCRIPTION']?></div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
