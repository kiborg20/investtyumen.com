<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
const NEWS_IBLOCK_ID = 9;
$arSelect = Array("ID",
    "NAME",
    "DETAIL_PAGE_URL",
    "DATE_ACTIVE_FROM",
    "PREVIEW_TEXT"
);
$arFilter = Array(
    "IBLOCK_ID" => NEWS_IBLOCK_ID,
    "ACTIVE"=>"Y"
);
$arSideElements = CIBlockElement::GetList(
    Array(
        "SORT"=>"DESC",
        "ACTIVE_FROM"=>"DESC"
    ),
    $arFilter,
    false,
    Array("nTopCount" => 4),
    $arSelect
);
while($arFieldsSideElement = $arSideElements->GetNext()){
    $arResultSideElements[] = $arFieldsSideElement;
}
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

            <div class="breadscrumbs__links">
                <a class="breadscrumbs__item" href="/">Главная</a>
                <span class="breadscrumbs__item">/</span>
                <span class="breadscrumbs__item">Пресс-центр</span>
            </div>
        </div>
    </div>
</section>

<section class="section section_padding-xl section_padding-bottom-none">
    <div class="wrapper wrapper_mode-s">
        <h1 class="headline headline_size-h1"><?=$arResult["NAME"]?></h1>
        <div class="date-icon">
            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#818990" fill-rule="evenodd" d="M4 5h2.25V3.75a.75.75 0 0 1 1.5 0V5h8.5V3.75a.75.75 0 0 1 1.5 0V5H20a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm16 1.5a.5.5 0 0 1 .5.5v2h-17V7a.5.5 0 0 1 .5-.5h16Zm-16 13a.5.5 0 0 1-.5-.5v-8.5h17V19a.5.5 0 0 1-.5.5H4Z" clip-rule="evenodd"/></svg></span>
            <?=FormatDateFromDB($arResult["ACTIVE_FROM"], "DD.MM.YYYY")?>
        </div>
    </div>
</section>

<? if ($arResult["DETAIL_PICTURE"]): ?>
<section class="section section_padding-m section_padding-bottom-none">
    <div class="wrapper wrapper_mode-l">
        <div class="image-content"><img alt="<?=$arResult["DETAIL_PICTURE"]["ALT"] ?>" src="//investintyumen.ru/<?=$arResult["DETAIL_PICTURE"]["SRC"] ?>" /></div>
    </div>

    <div class="wrapper wrapper_mode-s">
        <div class="description description_size-p2 description_c-black-60 description_padding-none">Фото: 1tmn.ru</div>
    </div>
</section>
<? endif; ?>

<section class="section section_padding-m">
    <div class="wrapper wrapper_mode-s">
        <div class="description description_size-p1 description_padding-none">
            <?=$arResult["DETAIL_TEXT"]?>
        </div>
    </div>
</section>

<section class="section section_padding-xl section_padding-top-none">
    <div class="wrapper wrapper_mode-s">
        <a class="button button_size-m button_theme-black" href="/news/">Вернуться ко всем новостям</a>
    </div>
</section>

<section class="section section_padding-xl">
    <div class="wrapper wrapper_mode-l">
        <div class="news-wrapper">
            <div class="news-wrapper__header">
                <div class="headline headline_size-h2 headline_padding-none">Будет интересно</div>

                <a class="button button_size-s button_theme-transparent" href="/news/">Читать все новости</a>
            </div>

            <div class="news">
                <? foreach($arResultSideElements as $item):
                if($item["ID"] === $arResult["ID"]){
                    continue;
                }?>
                <div class="news__item">
                    <div class="news__image"><a href="/news<?=$item["DETAIL_PAGE_URL"]?>"><img alt="<?=$item["NAME"]?>" src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>" /></a></div>

                    <div class="news__body">
                        <div class="news__date"><?=FormatDateFromDB($item["DATE_ACTIVE_FROM"], "DD.MM.YYYY")?></div>

                        <div class="news__title"><a href="/news<?=$item["DETAIL_PAGE_URL"]?>"><?=$item["NAME"]?></a></div>
                    </div>
                </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</section>
