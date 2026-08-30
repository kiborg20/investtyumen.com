<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalJS("/local/components/bitrix/newsonmain/newsonmain.js");
?>

<section class="section section_padding-xl">
    <div class="wrapper wrapper_mode-l">
        <div class="news-wrapper">
            <div class="news-wrapper__header">
                <div class="headline headline_size-h2 headline_padding-none">Пресс-центр</div>

                <a class="button button_size-s button_theme-transparent" href="/news/">Читать все новости</a>
            </div>

            <div class="news">
                <div class="news__item">
                    <div class="news__image"><a href="#"><img alt="" src="/statics/news1.jpg" /></a></div>

                    <div class="news__body">
                        <div class="news__date">24.04.2023</div>

                        <div class="news__title"><a href="#">В Тобольске открыли новый 4-звездочный отель</a></div>
                    </div>
                </div>

                <div class="news__item">
                    <div class="news__image"><a href="#"><img alt="" src="/statics/news2.jpg" /></a></div>

                    <div class="news__body">
                        <div class="news__date">19.01.2023</div>

                        <div class="news__title"><a href="#">Свой первый день рождения отметил футбольный центр «Дерби»</a></div>
                    </div>
                </div>

                <div class="news__item">
                    <div class="news__image"><a href="#"><img alt="" src="/statics/news3.jpg" /></a></div>

                    <div class="news__body">
                        <div class="news__date">09.01.2023</div>

                        <div class="news__title"><a href="#">Новый физкультурно-спортивный центр с бассейном и фитнес-залами откроется в Заречном микрорайоне в 2023 году</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?/*
<section class="newsmain">
        <div class="container">
            <div class="topcard">
                <div class="topcard_header">
                    <div class="titlewithline ttu">Новости</div>
                </div>
                <div class="news_topcard_slider">
                    <?foreach ($arResult as $item): ?>
                    <?$file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
                      $img = CFile::GetPath($item["PREVIEW_PICTURE"]);?>
                    <div class="topcard_slide">
                        <div class="topcard_slide_img" style="background:url('<?=$img?>') no-repeat; background-size:cover;"></div>
                        <div class="topcard_slide_right">
                            <div class="topcard_slide_text">
                                <div class="news_slider_date"><?=FormatDateFromDB($item["DATE_ACTIVE_FROM"], 'DD.MM.YYYY')?></div>

                                <div class="news_slider_text"><?=$item["NAME"]?></div>
                                <a href="/news<?=$item["DETAIL_PAGE_URL"]?>" class="news_slider_link">читать далее</a>
                            </div>
                            <!--<div class="topcard_slide_tags">-->
                            <!--    <a href="#" class="newstag">Недвижимость</a>-->
                            <!--    <a href="#" class="newstag">Общество</a>-->
                            <!--    <a href="#" class="newstag">Работа с населением</a>-->
                            <!--    <a href="#" class="newstag">Рощино</a>-->
                            <!--</div>-->
                        </div>
                    </div>
                    <?endforeach;?>
                </div>

            </div>
            <div class="botcard">
                <div class="news_botcard_slider">
                    <?$sliced2 = array_slice($arResult, 1); // можно использовать в нескольких местах?>

                    <?foreach ($sliced2 as $item): ?>
                    <?$file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
                      $img = CFile::GetPath($item["PREVIEW_PICTURE"]);?>
                    <div class="botcard_slide">
                        <div class="topcard_slide_text">
                            <div class="news_slider_date"><?=FormatDateFromDB($item["DATE_ACTIVE_FROM"], 'DD.MM.YYYY')?></div>
                            <div class="news_slider_text"><?=$item["NAME"]?></div>
                            <a href="/news<?=$item["DETAIL_PAGE_URL"]?>" class="news_slider_link">читать далее</a>
                        </div>
                        <!--<div class="topcard_slide_tags">-->
                        <!--    <a href="#" class="newstag">Общество</a>-->
                        <!--    <a href="#" class="newstag">Работа с населением</a>-->
                        <!--    <a href="#" class="newstag">Рощино</a>-->
                        <!--</div>-->
                    </div>
                    <?endforeach;?>
                    <div class="botcard_slide">
                            <a href="/news" class="btn btnwhite newsmorelink">Показать все</a>
                    </div>
                </div>
            </div>

            <div class="newsmobmain">
                <div class="titlewithline ttu">Новости</div>
                <?foreach ($arResult as $item): ?>
                <?$file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
                    $img = CFile::GetPath($item["PREVIEW_PICTURE"]);?>
                    <div class="newsmob_slide_img" style="background:url('<?=$img?>') no-repeat; background-size:cover;">
                        <a href="/news<?=$item["DETAIL_PAGE_URL"]?>" class="">
                            <div class="news_slider_date"><?=FormatDateFromDB($item["DATE_ACTIVE_FROM"], 'DD.MM.YYYY')?></div>
                            <div class="news_slider_text"><?=$item["NAME"]?></div>
                        </a>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </section>*/?>
