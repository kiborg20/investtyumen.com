<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!--TODO:: REFACTOR-->
<nav class="header-menu">
    <?if (!empty($arResult)):?>

    <div class="header-menu__left">

    <?
    $previousLevel = 0;
    foreach($arResult as $arItem):?>

        <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
            <?=str_repeat("</div></div></div></div></div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
        <?endif?>

        <?if ($arItem["IS_PARENT"]):?>

            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <div class="header-menu__item">
                    <?php if ($arItem['PARAMS']['NO_LINK']): ?>
                        <a href="#" data-submenu class="header-menu__link<?if ($arItem["SELECTED"]):?> header-menu__link_current<?endif?>"><?=$arItem["TEXT"]?></a>
                    <?php else: ?>
                        <a href="<?=$arItem["LINK"]?>" class="header-menu__link<?if ($arItem["SELECTED"]):?> header-menu__link_current<?endif?>">
                            <?=$arItem["TEXT"]?>
                        </a>
                    <?php endif; ?>

                    <div class="submenu-container">
                        <div class="wrapper wrapper_mode-l">
                            <div class="submenu">
                                <div class="submenu__item">
                                    <div class="headline headline_size-h3"><?=$arItem["TEXT"]?></div>

                                    <div class="submenu__hotlinks">
                                        <a class="submenu__link" href="/regional-standard/invest-map/">
                                            <span class="icon-block icon-block_size-s icon-block_theme-blue">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                                    <path fill="#fff" fill-rule="evenodd" d="M14.889 20.914 9.11 19.155a1.993 1.993 0 0 0-.837-.07l-5.016.655A2.003 2.003 0 0 1 1 17.748V5.73c0-1.01.746-1.862 1.742-1.992l5.532-.721c.28-.037.566-.013.837.07l5.778 1.758c.27.082.556.106.837.07l5.016-.655A2.003 2.003 0 0 1 23 6.252V18.27c0 1.01-.746 1.862-1.742 1.992l-5.532.721c-.28.037-.566.013-.837-.07Zm-.435-14.628c.032.01.064.02.096.028v12.922l-5.004-1.522a3.622 3.622 0 0 0-.096-.028V4.764l5.004 1.522ZM7.95 4.578l-5.014.654a.501.501 0 0 0-.436.498v12.018a.5.5 0 0 0 .564.498l4.886-.637V4.579Zm8.1 14.844 5.014-.654a.501.501 0 0 0 .436-.498V6.252a.5.5 0 0 0-.564-.498l-4.886.637v13.03Z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                            <span>Инвесткарта</span>
                                        </a>
                                        <a class="submenu__link" href="/investor/ofis-soprovozhdenia-investora/kuda-obratitsya/">
                                            <span class="icon-block icon-block_size-s icon-block_theme-blue">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13 17.75C13 18.3023 12.5523 18.75 12 18.75C11.4477 18.75 11 18.3023 11 17.75C11 17.1977 11.4477 16.75 12 16.75C12.5523 16.75 13 17.1977 13 17.75Z" fill="white"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 4C5.5 2.89543 6.39543 2 7.5 2H16.5C17.6046 2 18.5 2.89543 18.5 4V20C18.5 21.1046 17.6046 22 16.5 22H7.5C6.39543 22 5.5 21.1046 5.5 20V4ZM7 4C7 3.72386 7.22386 3.5 7.5 3.5H16.5C16.7761 3.5 17 3.72386 17 4V20C17 20.2761 16.7761 20.5 16.5 20.5H7.5C7.22386 20.5 7 20.2761 7 20V4Z" fill="white"/>
                                                </svg>
                                            </span>
                                            <span>Куда обратиться?</span>
                                        </a>
                                        <a class="submenu__link" href="/investor/question-answer/question/">
                                            <span class="icon-block icon-block_size-s icon-block_theme-blue">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4903 13.6263C11.212 13.6263 10.9736 13.3971 11.0167 13.1222C11.0381 12.9863 11.0699 12.8923 11.1123 12.7671C11.1276 12.722 11.1442 12.6728 11.1622 12.6162C11.2773 12.2646 11.4403 11.9802 11.6512 11.7629C11.8622 11.5455 12.1163 11.3474 12.4135 11.1684C12.6052 11.0469 12.7778 10.9111 12.9312 10.7609C13.0847 10.6107 13.2061 10.4381 13.2956 10.2431C13.3851 10.0482 13.4298 9.83244 13.4298 9.59593C13.4298 9.31148 13.3627 9.06539 13.2285 8.85765C13.0942 8.64991 12.9153 8.49011 12.6915 8.37825C12.471 8.26319 12.2249 8.20566 11.9533 8.20566C11.7072 8.20566 11.4723 8.2568 11.2485 8.35907C11.0248 8.46134 10.8394 8.62114 10.6924 8.83847C10.6187 8.94587 10.5606 9.06894 10.5183 9.20768C10.4413 9.45955 10.2336 9.66784 9.97027 9.66784H9.50078C9.21702 9.66784 8.985 9.43036 9.03856 9.1517C9.10695 8.79589 9.23317 8.48215 9.41722 8.21045C9.68568 7.81095 10.0404 7.50893 10.4815 7.30438C10.9257 7.09984 11.4163 6.99756 11.9533 6.99756C12.5413 6.99756 13.0559 7.10783 13.4969 7.32835C13.938 7.54568 14.28 7.8509 14.5229 8.24401C14.769 8.63393 14.892 9.08936 14.892 9.61031C14.892 9.96827 14.8361 10.2911 14.7242 10.5787C14.6124 10.8632 14.4526 11.1173 14.2448 11.341C14.0403 11.5647 13.7942 11.7629 13.5065 11.9354C13.2349 12.1048 13.0143 12.2806 12.845 12.4628C12.6788 12.645 12.5573 12.8607 12.4806 13.11C12.4695 13.1461 12.459 13.1827 12.4491 13.2187C12.3852 13.4522 12.1798 13.6263 11.9377 13.6263H11.4903Z" fill="white"/>
                                                    <path d="M11.7088 17.0411C11.4467 17.0411 11.2214 16.9484 11.0328 16.763C10.8442 16.5745 10.75 16.3476 10.75 16.0823C10.75 15.8202 10.8442 15.5965 11.0328 15.4111C11.2214 15.2226 11.4467 15.1283 11.7088 15.1283C11.9676 15.1283 12.1914 15.2226 12.3799 15.4111C12.5717 15.5965 12.6676 15.8202 12.6676 16.0823C12.6676 16.2581 12.6228 16.4195 12.5333 16.5665C12.447 16.7103 12.332 16.8254 12.1882 16.9116C12.0443 16.9979 11.8845 17.0411 11.7088 17.0411Z" fill="white"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C7.30558 20.5 3.5 16.6944 3.5 12C3.5 7.30558 7.30558 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12Z" fill="white"/>
                                                </svg>
                                            </span>
                                            <span>Вопрос-Ответ</span>
                                        </a>
                                        <a class="submenu__link" href="/investor/infrastructure-support/zakonodatelstvo/">
                                            <span class="icon-block icon-block_size-s icon-block_theme-blue">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14 14C14 14.4142 13.6642 14.75 13.25 14.75H8.75C8.33578 14.75 8 14.4142 8 14C8 13.5858 8.33578 13.25 8.75 13.25H13.25C13.6642 13.25 14 13.5858 14 14Z" fill="white"/>
                                                    <path d="M16 10C16 10.4142 15.6642 10.75 15.25 10.75H8.75C8.33578 10.75 8 10.4142 8 10C8 9.58581 8.33578 9.25002 8.75 9.25002H15.25C15.6642 9.25002 16 9.58581 16 10Z" fill="white"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.4142 6.41422C19.7893 6.78929 20 7.298 20 7.82843V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V4C4 2.89543 4.89543 2 6 2H14.1716C14.702 2 15.2107 2.21071 15.5858 2.58579L19.4142 6.41422ZM18.5 7.82843V20C18.5 20.2762 18.2762 20.5 18 20.5H6C5.72385 20.5 5.5 20.2762 5.5 20V4C5.5 3.72386 5.72386 3.5 6 3.5H14.1716C14.3042 3.5 14.4314 3.55268 14.5251 3.64645L18.3536 7.47488C18.4473 7.56865 18.5 7.69583 18.5 7.82843Z" fill="white"/>
                                                </svg>
                                            </span>    
                                            <span>Документация</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="submenu__item">
            <?else:?>
                <div class="fsdg">
                    <a href="<?=$arItem["LINK"]?>" class="header-menu__link<?if ($arItem["SELECTED"]):?> header-menu__link_current<?endif?>"><?=$arItem["TEXT"]?></a>
                <div>
            <?endif?>

        <?else:?>

            <?if ($arItem["PERMISSION"] > "D"):?>

                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                    <div class="header-menu__item">
                        <a href="<?=$arItem["LINK"]?>" class="header-menu__link<?if ($arItem["SELECTED"]):?> header-menu__link_current<?endif?>"><?=$arItem["TEXT"]?></a>
                    </div>
                <?else:?>
                    <?php if ($arItem['PARAMS']['NO_LINK']): ?>
                        <p class="submenu__label"><?=$arItem["TEXT"]?></p>
                    <?php else: ?>
                        <p><a class="submenu__link<?if ($arItem["SELECTED"]):?> submenu__link_current<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></p>
                    <?php endif; ?>
                <?endif?>

            <?endif?>

        <?endif?>

        <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

    <?endforeach?>

    <?if ($previousLevel > 1)://close last item tags?>
        <?=str_repeat("</div></div>", ($previousLevel-1) );?>
    <?endif?>

    </div>
    <?endif?>

    <div class="header-menu__right">
        <div class="header-menu__item">
        <a data-search-header="header-search" class="button" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" fill-rule="evenodd" d="M10.54 3a7.54 7.54 0 1 0 4.667 13.461l4.279 4.28a.887.887 0 0 0 1.254-1.255l-4.279-4.28A7.54 7.54 0 0 0 10.54 3Zm-5.766 7.54a5.766 5.766 0 1 1 11.531 0 5.766 5.766 0 0 1-11.531 0Z" clip-rule="evenodd"/></svg>
        </a>
        </div>
    </div>

    <div class="header-search">
        <form action="/search" method="get">
            <div class="header-search__block">
                <button class="button" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#4A66F5" fill-rule="evenodd" d="M10.54 3a7.54 7.54 0 1 0 4.667 13.461l4.279 4.28a.887.887 0 0 0 1.254-1.255l-4.279-4.28A7.54 7.54 0 0 0 10.54 3Zm-5.766 7.54a5.766 5.766 0 1 1 11.531 0 5.766 5.766 0 0 1-11.531 0Z" clip-rule="evenodd"/></svg>
                </button>

                <input class="header-search__input" type="text" name="q" placeholder="Что будем искать?" />
            </div>

            <div class="header-search__button">
                <a class="button" data-search-header="header-search" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" fill-rule="evenodd" d="M6.355 5.234a.791.791 0 0 0-1.123 0 .8.8 0 0 0 0 1.127l5.646 5.671-5.582 5.607a.8.8 0 0 0 0 1.127.791.791 0 0 0 1.123 0l5.582-5.606 5.582 5.606a.791.791 0 0 0 1.123 0 .8.8 0 0 0 0-1.127l-5.582-5.607 5.646-5.67a.8.8 0 0 0 0-1.128.791.791 0 0 0-1.123 0L12 10.904l-5.646-5.67Z" clip-rule="evenodd"/></svg></a>
            </div>
        </form>
    </div>
</nav>
