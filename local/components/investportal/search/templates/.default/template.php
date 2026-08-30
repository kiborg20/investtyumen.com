<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<section class="section section_padding-m">
    <div class="wrapper wrapper_mode-s">
        <div class="page-header-search">
            <form class="" action="" method="get">
                <div class="page-header-search__block">
                    <div class="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#4A66F5" fill-rule="evenodd" d="M10.54 3a7.54 7.54 0 1 0 4.667 13.461l4.279 4.28a.887.887 0 0 0 1.254-1.255l-4.279-4.28A7.54 7.54 0 0 0 10.54 3Zm-5.766 7.54a5.766 5.766 0 1 1 11.531 0 5.766 5.766 0 0 1-11.531 0Z" clip-rule="evenodd"/></svg>
                    </div>

                    <input class="page-header-search__input" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />

                    <div class="page-header-search__button">
                        <a class="button" data-search-header="page-header-search" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" fill-rule="evenodd" d="M6.355 5.234a.791.791 0 0 0-1.123 0 .8.8 0 0 0 0 1.127l5.646 5.671-5.582 5.607a.8.8 0 0 0 0 1.127.791.791 0 0 0 1.123 0l5.582-5.606 5.582 5.606a.791.791 0 0 0 1.123 0 .8.8 0 0 0 0-1.127l-5.582-5.607 5.646-5.67a.8.8 0 0 0 0-1.128.791.791 0 0 0-1.123 0L12 10.904l-5.646-5.67Z" clip-rule="evenodd"/></svg></a>
                    </div>
                </div>

                <button class="button button_theme-blue button_size-s" type="submit">Найти</button>
                <input  type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
            </form>
            <div>
            </div>
</section>

<section class="section section_padding-s">
    <div class="wrapper wrapper_mode-s">
        <div class="container search-page">
            <?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
                ?>
                <div class="search-language-guess">
                    <?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
                </div><br /><?
            endif;?>

            <?if($arResult["ITEMS"]):?>
                <h2 class="headline headline_size-h2">
                    Результаты по запросу «<?=$arResult["REQUEST"]["QUERY"]?>»
                </h2>

                <br />
                <?foreach($arResult["ITEMS"] as $arItem):?>
                    <div class="search-results_item">
                        <a class="headline headline_size-h5" href="<?echo $arItem["URL"] == '/' ? '/' : '/' . $arItem['URL'] ?>"><?echo $arItem["TAG"]?></a>
                        <p class="description description_size-p2"><?echo $arItem["CONTENT"]?></p>
                    </div>
                <?endforeach;?>

            <?else:?>
                <section class="section-not-found section section_padding-xxl">
                    <div class="wrapper wrapper_mode-l">
                        <div class="icon-block">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.25 10C10.25 10.6904 9.69036 11.25 9 11.25C8.30964 11.25 7.75 10.6904 7.75 10C7.75 9.30965 8.30964 8.75 9 8.75C9.69036 8.75 10.25 9.30965 10.25 10Z" fill="white"/>
                                <path d="M16.25 10C16.25 10.6904 15.6904 11.25 15 11.25C14.3096 11.25 13.75 10.6904 13.75 10C13.75 9.30965 14.3096 8.75 15 8.75C15.6904 8.75 16.25 9.30965 16.25 10Z" fill="white"/>
                                <path d="M14.3691 15.775C14.6527 16.0769 15.1063 16.2074 15.4649 16C15.8234 15.7926 15.9501 15.329 15.6889 15.0075C14.8188 13.9362 13.4898 13.25 12 13.25C10.5102 13.25 9.18128 13.9362 8.3111 15.0075C8.04995 15.329 8.1766 15.7926 8.53515 16C8.89369 16.2074 9.34732 16.0769 9.63093 15.775C10.2243 15.1433 11.0665 14.75 12 14.75C12.9335 14.75 13.7757 15.1433 14.3691 15.775Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20.5C16.6944 20.5 20.5 16.6944 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5Z" fill="white"/>
                            </svg>
                        </div>

                        <h2 class="headline headline_size-h2">
                            Мы ничего не нашли по запросу «<?=$arResult["REQUEST"]["QUERY"]?>»
                        </h2>
                        <p class="description description_size-p1 description_padding-none">
                            Попробуйте изменить условия поиска
                        </p>
                    </div>
                </section>
            <?endif;?>
        </div>
    </div>
</section>