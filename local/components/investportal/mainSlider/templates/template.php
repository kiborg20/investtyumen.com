<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<section class="section section_padding-m section_padding-top-none">
    <div class="wrapper wrapper_mode-l">
        <div class="main-slider">
            <div class="swiper-wrapper">
                {%for item in arResult%}
                <div class="swiper-slide main-slider__item">
                    <div class="main-slider__wrapper">
                        <div class="main-slider__image" style="background-image: url(/statics/slider-image.jpg)"></div>
                    </div>

                    <div class="main-slider__card">
                        <div class="main-slider__card-body">
                            <div class="headline headline_size-h2 headline_between">
                                <span>1 место</span>
                                <span class="icon-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" fill-rule="evenodd" d="M19 4h2a2 2 0 0 1 2 2v3a4 4 0 0 1-4 4h-.674a7.005 7.005 0 0 1-5.576 3.96v3.54h2.5a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1 0-1.5h2.5v-3.54A7.005 7.005 0 0 1 5.674 13H5a4 4 0 0 1-4-4V6a2 2 0 0 1 2-2h2v-.125C5 2.839 5.84 2 6.875 2h10.25C18.16 2 19 2.84 19 3.875V4ZM6.5 3.875c0-.207.168-.375.375-.375h10.25c.207 0 .375.168.375.375V10a5.5 5.5 0 1 1-11 0V3.875ZM18.839 11.5H19A2.5 2.5 0 0 0 21.5 9V6a.5.5 0 0 0-.5-.5h-2V10c0 .515-.056 1.017-.161 1.5Zm-13.678 0A7.026 7.026 0 0 1 5 10V5.5H3a.5.5 0 0 0-.5.5v3A2.5 2.5 0 0 0 5 11.5h.161Z" clip-rule="evenodd"/></svg></span>
                            </div>

                            <div class="description description_size-p1 description_padding-top-xl "><p>в рейтинге «Эффективность управления»  Агенства политических и экономических коммуникаций.</p></div>
                        </div>

                        <div class="main-slider__card-footer">
                            <div class="description description_size-p2 description_padding-none">2016-2021</div>

                            <div>
                                <a class="more-link" href="#">
                                    <span>Подробнее</span>
                                    <span class="more-link__icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path stroke="#4A66F5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.143 3H13m0 0v7.857M13 3 3 13"/></svg></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {% endfor %}
            </div>

            <div class="main-slider__title"><div class="headline headline_size-h1"><?=htmlspecialchars_decode($arParams['HEROTITLE']);?></div></div>
        </div>
    </div>
</section>

<?/* <section class="heroblock">
        <div class="heroslider">
            <?foreach ($arResult as $item): ?>
            <?
                $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 1920,'height' => 1080), BX_RESIZE_IMAGE_EXACT, true);
            ?>
                <?if ($item["PROPERTY_IT_VIDEO_VALUE"]){
                    $video = CFile::GetPath($item["PROPERTY_IT_VIDEO_VALUE"]);

                }?>
            <div class="slide" style="position:relative;">
                <?if ($item["PROPERTY_IT_VIDEO_VALUE"]){?>

                <a class="playBtn vidplay"></a>
                <video class="vid1" width="100%"style="margin-top:-160px"  poster="<?=$file['src']?>">
                    <source src="<?=$video?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                </video><?} else {?>
                <div style="background: url('https://investintyumen.ru/<?=$file['src']?>') no-repeat;"></div>
                <?};?>
            </div>
            <?endforeach;?>
        </div>
        <div class="herosecondrow">
            <div class="container">
                <div class="herotitle">
                    <h1><?=htmlspecialchars_decode($arParams['HEROTITLE']);?></span></h1>
                    <?
                    $i=0;
                    foreach ($arResult as $item):
                        if(!$item["PROPERTY_IT_NOMINATION_VALUE"] or !$item["PROPERTY_IT_RAIT_VALUE"] or !$item["PROPERTY_IT_YEAR_VALUE"]){
                            $i++;
                    };endforeach;
                    if ($i==0){
                    ?>

                    <div class="herosubtitle">
                        <div class="herosubtitleslider">
                            <?foreach ($arResult as $item):
                            if(!$item["PROPERTY_IT_NOMINATION_VALUE"] or !$item["PROPERTY_IT_RAIT_VALUE"] or $item["PROPERTY_IT_YEAR_VALUE"]){
                            ?>

                            <div class="slide">
                                <div class="first"><img src="/images/1.svg" alt=""></div>
                                <div class="place">место</div>
                                <div class="what"><?=htmlspecialchars_decode($item["PROPERTY_IT_NOMINATION_VALUE"])?></div>
                                <div class="who"><?=htmlspecialchars_decode($item["PROPERTY_IT_RAIT_VALUE"])?></div>
                                <div class="year"><?=htmlspecialchars_decode(   $item["PROPERTY_IT_YEAR_VALUE"])?></div>
                            </div>
                            <?};endforeach;?>
                        </div>
                    </div><?};?>
                </div>
                <div class="heropagin">
                    <div class="heropaginslider">
                        <?foreach ($arResult as $item): ?>
                        <?
                            $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 240, 'height' => 135), BX_RESIZE_IMAGE_EXACT, true);
                        ?>
                        <div class="slide">
                            <div style="background: url('https://investintyumen.ru/<?=$file['src']?>') no-repeat;"></div>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </section> */?>
