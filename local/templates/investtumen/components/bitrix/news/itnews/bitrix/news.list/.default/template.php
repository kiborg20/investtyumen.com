<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
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

            <?php $APPLICATION->IncludeComponent('bitrix:breadcrumb', '', [
                'START_FROM' => 1,
            ]); ?>
        </div>
    </div>
</section>

<section class="section section_padding-xl section_padding-bottom-none">
    <div class="wrapper wrapper_mode-l">
        <div class="news-wrapper">
            <div class="news-wrapper__header">
                <div class="headline headline_size-h2 headline_padding-none">Пресс-центр</div>
            </div>

            <div class="news">
                <? foreach(array_slice($arResult["ITEMS"], 0, 9) as $arItem):?>
                <div class="news__item">
                    <div class="news__image"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><img alt="<?echo $arItem["NAME"]?>" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" /></a></div>

                    <div class="news__body">
                        <div class="news__date">
                            <?echo $arItem["DISPLAY_ACTIVE_FROM"]?>
                            <a href="#">Новость</a>
                        </div>

                        <div class="news__title"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
                    </div>
                </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</section>

<section class="seaction section_padding-xl section_padding-top-none">
    <div class="wrapper wrapper_mode-l">
        <?=$arResult['NAV_STRING'] ?>
    </div>
</section>

<section class="seaction section_padding-xl">
    <div class="wrapper wrapper_mode-l">
        <div class="headline headline_size-h2">Презентации</div>

        <div class="link-cards">
            <div class="link-cards__item">
                <a class="link-cards__link" href="/investoru/?FROM_MEDIA=Y">
                    <div class="description description_size-p1 description_padding-none">Кейсы — готовые бизнес-предложения</div>
                    <div class="icon-block icon-block_theme-white icon-block_size-m"></div>
                </a>
            </div>

            <div class="link-cards__item">
                <a class="link-cards__link" href="/upload/files/presentation/region_pervyh_temnaya_na_19_09.pdf">
                    <div class="description description_size-p1 description_padding-none">Инвестиционные возможности Тюменской области</div>
                    <div class="icon-block icon-block_theme-white icon-block_size-m"></div>
                </a>
            </div>

            <div class="link-cards__item">
                <a class="link-cards__link" href="/upload/files/presentation/Klaster_ZHemchuzhina_Sibiri.pdf">
                    <div class="description description_size-p1 description_padding-none">Кластер «Жемчужина Сибири»</div>
                    <div class="icon-block icon-block_theme-white icon-block_size-m"></div>
                </a>
            </div>

            <div class="link-cards__item">
                <a class="link-cards__link" href="/upload/files/%D0%9F%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D0%B0_%D0%B1%D0%B8%D0%B7%D0%BD%D0%B5%D1%81%D0%B0_%D0%B2_%D0%A2%D0%9E_%D1%82%D1%83%D1%80%D0%B8%D0%B7%D0%BC_%D0%B8%D1%82%D0%BE%D0%B3_20_07.pdf">
                    <div class="description description_size-p1 description_padding-none">Меры поддержки туризма</div>
                    <div class="icon-block icon-block_theme-white icon-block_size-m"></div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section section_padding-xl">
    <div class="wrapper wrapper_mode-l">
        <div class="card card_theme-transparent">
            <div class="card__item card__item_between card__item_padding-none">
                <div class="row">
                    <div class="headline headline_size-h2"><p>Стань частью бренда<br />Invest Tyumen</p></div>

                    <div class="description description_size-p1"><p>Если вы&nbsp;хотите использовать фирменную символику инвестиционного бренда Тюменской области для продвижения услуг или товаров вашей компании или стать амбассадором бренда, напишите нам, мы&nbsp;вышлем вам архив с&nbsp;элементами фирменного стиля.</p></div>
                </div>

                <div class="row"><a class="button button_size-m button_theme-blue" href="#">Получить архив</a></div>
            </div>

            <div class="card__item card__item_padding-none">
                <div class="image-container image-container_bg person-image" style="background-image: url('/statics/photo.jpg');"></div>
            </div>
        </div>
    </div>
</section>
