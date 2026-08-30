<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
    $APPLICATION->AddHeadScript('/local/templates/investtumen/js/Inputmask/dist/inputmask.min.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/script.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/consult-form.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/ask-question-form.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/js/vcard.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/js/popup-video.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/js/popup-zoom.js');
    $APPLICATION->AddHeadScript('/local/templates/investtumen/js/modals.js');

use Bitrix\Main\Page\Asset;
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />
    <meta name="google-site-verification" content="XvOMIVsmIlmjRVbfJ3Eb_0K1V02dYd2W4NqDVycUP0Q" />
    <title><?$APPLICATION->ShowTitle(true);?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <?$APPLICATION->ShowHead();?>
</head>
<body>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(86690882, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/86690882" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <?/*
    <style>
        .munitsipalnoe-obrazovanie {
            display: none;
        }
        <?if($_GET['test'] == 'Y'):?>
            .munitsipalnoe-obrazovanie {
                display: block;
            }
        <?endif;?>
    </style>
    */?>
    <div id="panel">
		<?$APPLICATION->ShowPanel();?>
	</div>

    <header>
        <div class="section section_padding-xs section_padding-top-none">
            <div class="wrapper wrapper_mode-l">
                <div class="header__top">
                    <div class="header__row">
                        <div class="description strong description_size-p2 description_padding-none description_c-black-60">
                            Инвестиционный портал Тюменской области
                        </div>
                    </div>
                    <div class="header__row">
                        <div class="header__item">
                            <div class="dropdown">
                                <div class="dropdown__label">
                                    <a data-dropdown-label href="/">
                                        <span>RU</span>
                                        <span class="button button_padding-none no-border button_theme-transparent"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#818990" d="m8.073 10 3.94 3.94L15.952 10a.75.75 0 1 1 1.06 1.06l-4.469 4.47a.75.75 0 0 1-1.06 0l-4.47-4.47A.75.75 0 1 1 8.073 10Z"/></svg></span>
                                    </a>
                                </div>

                                <div data-dropdown-list class="dropdown__list">
                                    <div><a href="/landings/en">EN</a></div>
                                    <div><a href="/landings/chi">CHI</a></div>
                                    <div><a href="/landings/ae">AE</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="header__phone description strong description_size-p2 description_padding-none description_c-black-60">
                            8 (800) 550-08-30
                        </div>
                    </div>
                </div>
                <div class="header">
                    <div class="header__row">
                        <div class="header__item">
                            <a class="button" href="/">
                                <img alt="Инвест Тюмень" src="<?= SITE_TEMPLATE_PATH ?>/img/logo.svg" />
                            </a>
                        </div>

                        <div class="header__item header__item_menu">
                            <div class="menu-mobile">
                                <a data-tablet-menu class="button button_size-m" href="#">
                                    <span class="button__icon button__icon_left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" d="M3 9.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9.25ZM3 14.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 1 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"/></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" fill-rule="evenodd" d="M6.355 5.234a.791.791 0 0 0-1.122 0 .8.8 0 0 0 0 1.127l5.645 5.671-5.581 5.607a.8.8 0 0 0 0 1.127.791.791 0 0 0 1.122 0l5.582-5.606 5.582 5.606a.792.792 0 0 0 1.123 0 .8.8 0 0 0 0-1.127l-5.582-5.607 5.646-5.67a.8.8 0 0 0 0-1.128.791.791 0 0 0-1.123 0L12 10.904l-5.646-5.67Z" clip-rule="evenodd"/></svg>
                                    </span>
                                    <span>Меню</span>
                                </a>
                            </div>

                            <div class="modal-menu-tablet">
                                <div class="toggle-menu">
                                    <div class="toggle-menu__item">
                                        <div class="toggle-menu__head">
                                            <a data-handler-menu href="#">
                                                <span>О регионе</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" d="m8.073 10 3.94 3.94L15.952 10a.75.75 0 1 1 1.06 1.06l-4.469 4.47a.75.75 0 0 1-1.06 0l-4.47-4.47A.75.75 0 1 1 8.073 10Z"/></svg>
                                            </a>
                                        </div>

                                        <div class="toggle-menu__list">
                                            <div class="toggle-menu__row">
                                                <p><a href="/about/demografiya/">Демография</a></p>

                                                <p><a href="/about/kachestvo-zhizni/">Качество жизни</a></p>

                                                <p><a href="/about/biznes-sreda/">Бизнес-среда</a></p>

                                                <p><a href="/about/geografiya-i-logistika/">География и логистика</a></p>

                                                <p><a href="/about/prirodnyj-potencial/">Природный потенциал</a></p>

                                                <p><a href="/about/vneshnyaya-torgovlya/">Внешняя торговля</a></p>

                                                <p><a href="/about/nauka-i-innovacii/">Наука и инновации</a></p>

                                                <p><a href="/about/ekonomika-i-resursy/">Экономика и ресурсы</a></p>

                                                <p><a href="/about/investicionnyj-potencial/">Инвестиционный потенциал</a></p>

                                                <p><a href="/about/success-stories/">Истории успеха</a></p>
                                            </div>

                                            <div class="toggle-menu__row">
                                                <p>
                                                    <a href="#">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" d="m12.751 13.189 3.19-3.19A.75.75 0 1 1 17 11.06l-4.47 4.47a.75.75 0 0 1-1.06 0L7 11.06A.75.75 0 1 1 8.061 10l3.19 3.189V2.749a.75.75 0 0 1 1.5 0v10.44Z"/><path fill="#fff" d="M4.751 14.75a.75.75 0 1 0-1.5 0V19c0 .966.783 1.75 1.75 1.75h14a1.75 1.75 0 0 0 1.75-1.75v-4.25a.75.75 0 1 0-1.5 0V19a.25.25 0 0 1-.25.25h-14a.25.25 0 0 1-.25-.25v-4.25Z"/></svg></span>
                                                        <span>Скачать презентацию</span>
                                                    </a>
                                                </p>

                                                <p>
                                                    <a href="/regional-standard/invest-map/">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" fill-rule="evenodd" d="M14.889 20.914 9.11 19.155a1.993 1.993 0 0 0-.837-.07l-5.016.655A2.003 2.003 0 0 1 1 17.748V5.73c0-1.01.746-1.862 1.742-1.992l5.532-.721c.28-.037.566-.013.837.07l5.778 1.758c.27.082.556.106.837.07l5.016-.655A2.003 2.003 0 0 1 23 6.252V18.27c0 1.01-.746 1.862-1.742 1.992l-5.532.721c-.28.037-.566.013-.837-.07Zm-.435-14.628c.032.01.064.02.096.028v12.922l-5.004-1.522a3.622 3.622 0 0 0-.096-.028V4.764l5.004 1.522ZM7.95 4.578l-5.014.654a.501.501 0 0 0-.436.498v12.018a.5.5 0 0 0 .564.498l4.886-.637V4.579Zm8.1 14.844 5.014-.654a.501.501 0 0 0 .436-.498V6.252a.5.5 0 0 0-.564-.498l-4.886.637v13.03Z" clip-rule="evenodd"/></svg></span>
                                                        <span>Инвесткарта</span>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="toggle-menu__item">
                                        <div class="toggle-menu__head">
                                            <a data-handler-menu href="#">
                                                <span>Инвестору</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" d="m8.073 10 3.94 3.94L15.952 10a.75.75 0 1 1 1.06 1.06l-4.469 4.47a.75.75 0 0 1-1.06 0l-4.47-4.47A.75.75 0 1 1 8.073 10Z"/></svg>
                                            </a>
                                        </div>

                                        <div class="toggle-menu__list">
                                            <div class="toggle-menu__row">
                                                <p>Офис сопровождения инвестора</p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/soprovozhdenie/">Сопровождение</a></p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/electronic-services/">Электронные сервисы</a></p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/investicionnyj-tury/">Инвестиционные туры</a></p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/konserzh-uslugi/">Консьерж-услуги</a></p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/investment-projects/">Инвестиционные проекты</a></p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/kuda-obratitsya/">Куда обратиться</a></p>

                                                <p><a href="/investor/ofis-soprovozhdenia-investora/faq/">Часто задаваемые вопросы</a></p>
                                            </div>

                                            <div class="toggle-menu__row">
                                                <p>Инфраструктура поддержки</p>

                                                <p><a href="/investor/infrastructure-support/investagenstvo/">Инвестагентство</a></p>

                                                <p><a href="/investor/infrastructure-support/air/">АИР</a></p>

                                                <p><a href="/investor/infrastructure-support/dip/">ДИП</a></p>

                                                <p><a href="/investor/infrastructure-support/my-business/">Мой бизнес</a></p>

                                                <p><a href="/investor/infrastructure-support/tehnopark/">Технопарк</a></p>

                                                <p><a href="/investor/infrastructure-support/fmf/">ФМФ</a></p>

                                                <p><a href="/investor/infrastructure-support/zakonodatelstvo/">Законодательство</a></p>
                                            </div>

                                            <div class="toggle-menu__row">
                                                <p>Меры поддержки</p>

                                                <p><a href="/investor/support-measures/instrumenty-finansovoy-podderzhki/">Финансовые</a></p>

                                                <p><a href="/investor/support-measures/nalogovye-lgoty/">Налоговые льготы</a></p>

                                                <p><a href="/investor/support-measures/instrumenty-imushchestvennoj-podderzhki/">Имущественная поддержка</a></p>

                                                <p><a href="/investor/support-measures/vneshneekonomicheskaya-deyatelnost/">Внешнеэкономическая деятельность</a></p>
                                            </div>

                                            <div class="toggle-menu__row">
                                                <p>
                                                    <a href="/regional-standard/invest-map/">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" fill-rule="evenodd" d="M14.889 20.914 9.11 19.155a1.993 1.993 0 0 0-.837-.07l-5.016.655A2.003 2.003 0 0 1 1 17.748V5.73c0-1.01.746-1.862 1.742-1.992l5.532-.721c.28-.037.566-.013.837.07l5.778 1.758c.27.082.556.106.837.07l5.016-.655A2.003 2.003 0 0 1 23 6.252V18.27c0 1.01-.746 1.862-1.742 1.992l-5.532.721c-.28.037-.566.013-.837-.07Zm-.435-14.628c.032.01.064.02.096.028v12.922l-5.004-1.522a3.622 3.622 0 0 0-.096-.028V4.764l5.004 1.522ZM7.95 4.578l-5.014.654a.501.501 0 0 0-.436.498v12.018a.5.5 0 0 0 .564.498l4.886-.637V4.579Zm8.1 14.844 5.014-.654a.501.501 0 0 0 .436-.498V6.252a.5.5 0 0 0-.564-.498l-4.886.637v13.03Z" clip-rule="evenodd"/></svg></span>
                                                        <span>Инвесткарта</span>
                                                    </a>
                                                </p>

                                                <p>
                                                    <a href="/investor/ofis-soprovozhdenia-investora/kuda-obratitsya/">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" d="M13 17.75a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/><path fill="#fff" fill-rule="evenodd" d="M5.5 4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-9a2 2 0 0 1-2-2V4ZM7 4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v16a.5.5 0 0 1-.5.5h-9A.5.5 0 0 1 7 20V4Z" clip-rule="evenodd"/></svg></span>
                                                        <span>Куда обратиться?</span>
                                                    </a>
                                                </p>

                                                <p>
                                                    <a href="/investor/ofis-soprovozhdenia-investora/faq/">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" d="M11.49 13.626c-.278 0-.516-.229-.473-.504.021-.136.053-.23.095-.355l.05-.15c.115-.352.278-.637.49-.854.21-.217.464-.416.762-.595.191-.121.364-.257.517-.407.154-.15.275-.323.365-.518.09-.195.134-.41.134-.647 0-.285-.067-.53-.201-.738a1.342 1.342 0 0 0-.537-.48 1.571 1.571 0 0 0-.739-.172c-.246 0-.48.05-.704.153-.224.102-.41.262-.557.48-.073.107-.131.23-.174.369-.077.252-.284.46-.548.46H9.5c-.283 0-.515-.238-.461-.516.068-.356.194-.67.378-.942a2.55 2.55 0 0 1 1.065-.906 3.477 3.477 0 0 1 1.471-.306c.588 0 1.103.11 1.544.33.441.218.783.523 1.026.916.246.39.369.845.369 1.366 0 .358-.056.681-.168.969a2.4 2.4 0 0 1-.48.762c-.204.224-.45.422-.737.594-.272.17-.493.346-.662.528a1.678 1.678 0 0 0-.364.647 3.796 3.796 0 0 0-.032.109.54.54 0 0 1-.511.407h-.448ZM11.709 17.041a.93.93 0 0 1-.676-.278.928.928 0 0 1-.283-.68c0-.263.094-.486.283-.672a.923.923 0 0 1 .676-.283c.259 0 .482.095.67.283a.9.9 0 0 1 .289.671.913.913 0 0 1-.135.485.99.99 0 0 1-.345.345.914.914 0 0 1-.48.13Z"/><path fill="#fff" fill-rule="evenodd" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10Zm-1.5 0a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0Z" clip-rule="evenodd"/></svg></span>
                                                        <span>Вопрос-ответ</span>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="toggle-menu__item">
                                        <div class="toggle-menu__head">
                                            <a data-handler-menu href="#">
                                                <span>Сферы роста</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" d="m8.073 10 3.94 3.94L15.952 10a.75.75 0 1 1 1.06 1.06l-4.469 4.47a.75.75 0 0 1-1.06 0l-4.47-4.47A.75.75 0 1 1 8.073 10Z"/></svg>
                                            </a>
                                        </div>

                                        <div class="toggle-menu__list">
                                            <div class="toggle-menu__row">
                                                <p><a href="/growth-area/nefteservisnoe-oborudovanie-i-uslugi/">Нефтесервисное оборудование и услуги</a></p>

                                                <p><a href="/growth-area/neftekhimiya-i-pererabotka-polimerov/">Нефтехимия и переработка полимеров</a></p>

                                                <p><a href="/growth-area/lesopromyshlennyy-kompleks/">Лесопромышленный комплекс</a></p>

                                                <p><a href="/growth-area/turizm/">Туризм</a></p>

                                                <p><a href="/growth-area/dobycha-nefti/">Добыча нефти</a></p>

                                                <p><a href="/growth-area/kreativnye-industrii/">Креативные индестрии</a></p>

                                                <p><a href="/growth-area/stroitelstvo/">Строительство</a></p>

                                                <p><a href="/growth-area/munitsipalnoe-obrazovanie/">Муниципальное образование</a></p>

                                                <p><a href="/growth-area/biokhimiya/">Биотехнологии</a></p>

                                                <p><a href="/growth-area/industry/">Промышленность</a></p>

                                                <p><a href="/growth-area/investment-strategy/">Инвестиционная стратегия</a></p>
                                            </div>

                                            <div class="toggle-menu__row">
                                                <p>
                                                    <a href="#">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" d="m12.751 13.189 3.19-3.19A.75.75 0 1 1 17 11.06l-4.47 4.47a.75.75 0 0 1-1.06 0L7 11.06A.75.75 0 1 1 8.061 10l3.19 3.189V2.749a.75.75 0 0 1 1.5 0v10.44Z"/><path fill="#fff" d="M4.751 14.75a.75.75 0 1 0-1.5 0V19c0 .966.783 1.75 1.75 1.75h14a1.75 1.75 0 0 0 1.75-1.75v-4.25a.75.75 0 1 0-1.5 0V19a.25.25 0 0 1-.25.25h-14a.25.25 0 0 1-.25-.25v-4.25Z"/></svg></span>
                                                        <span>Скачать презентацию</span>
                                                    </a>
                                                </p>

                                                <p>
                                                    <a href="/regional-standard/invest-map/">
                                                        <span class="icon-block icon-block_size-s icon-block_theme-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" fill-rule="evenodd" d="M14.889 20.914 9.11 19.155a1.993 1.993 0 0 0-.837-.07l-5.016.655A2.003 2.003 0 0 1 1 17.748V5.73c0-1.01.746-1.862 1.742-1.992l5.532-.721c.28-.037.566-.013.837.07l5.778 1.758c.27.082.556.106.837.07l5.016-.655A2.003 2.003 0 0 1 23 6.252V18.27c0 1.01-.746 1.862-1.742 1.992l-5.532.721c-.28.037-.566.013-.837-.07Zm-.435-14.628c.032.01.064.02.096.028v12.922l-5.004-1.522a3.622 3.622 0 0 0-.096-.028V4.764l5.004 1.522ZM7.95 4.578l-5.014.654a.501.501 0 0 0-.436.498v12.018a.5.5 0 0 0 .564.498l4.886-.637V4.579Zm8.1 14.844 5.014-.654a.501.501 0 0 0 .436-.498V6.252a.5.5 0 0 0-.564-.498l-4.886.637v13.03Z" clip-rule="evenodd"/></svg></span>
                                                        <span>Инвесткарта</span>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="toggle-menu__item">
                                        <div class="toggle-menu__head">
                                            <a data-handler-menu href="#">
                                                <span>Регстандарт</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" d="m8.073 10 3.94 3.94L15.952 10a.75.75 0 1 1 1.06 1.06l-4.469 4.47a.75.75 0 0 1-1.06 0l-4.47-4.47A.75.75 0 1 1 8.073 10Z"/></svg>
                                            </a>
                                        </div>

                                        <div class="toggle-menu__list">
                                            <div class="toggle-menu__row">
                                                <p><a href="/regional-standard/agenstvo-razvitia/">Агентство развития</a></p>

                                                <p><a href="/regional-standard/invest-declaration/">Инвестиционная декларация</a></p>

                                                <p><a href="/regional-standard/invest-comitet/">Инвестиционный комитет</a></p>

                                                <p><a href="/regional-standard/invest-rules/">Свод инвестиционных правил</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="toggle-menu__item">
                                        <div class="toggle-menu__head">
                                            <a href="/press-center/">Пресс-центр</a>
                                        </div>
                                    </div>

                                    <div class="toggle-menu__item">
                                        <div class="toggle-menu__head">
                                            <a href="/contacts/">Контакты</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "horizontal_multilevel",
                                [
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "top_hidden",
                                    "COMPONENT_TEMPLATE" => "horizontal_multilevel",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "2",
                                    "MENU_CACHE_GET_VARS" => [
                                    ],
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "top",
                                    "USE_EXT" => "N",
                                ],
                                false
                            );?>
                        </div>
                    </div>

                    <div class="header__row">
                        <div class="header__item header__item_consult">
                            <a data-open-modal="consult" data-button="button_theme-transparent" class="button" href="#">Получить консультацию</a>
                        </div>

                        <div class="header__item header__item_search-button">
                            <a class="button" href="#">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5396 3C6.37558 3 3 6.37559 3 10.5396C3 14.7036 6.37558 18.0792 10.5396 18.0792C12.3016 18.0792 13.9235 17.4739 15.2068 16.4613L19.4857 20.7402C19.8322 21.0866 20.3938 21.0866 20.7402 20.7402C21.0866 20.3938 21.0866 19.8322 20.7402 19.4858L16.4612 15.2069C17.4739 13.9234 18.0792 12.3016 18.0792 10.5396C18.0792 6.37559 14.7036 3 10.5396 3ZM4.77402 10.5396C4.77402 7.35536 7.35534 4.77402 10.5396 4.77402C13.7238 4.77402 16.3052 7.35536 16.3052 10.5396C16.3052 12.132 15.6608 13.5721 14.6164 14.6165C13.5721 15.6608 12.132 16.3052 10.5396 16.3052C7.35534 16.3052 4.77402 13.7239 4.77402 10.5396Z" fill="#252830"/>
                                </svg>
                            </a>
                        </div>

                        <div class="header__item">
                            <a class="button button_theme-blue" href="https://investintyumen.ru/auth/" target="_blank">
                                <span class="button__icon button__icon_left"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#fff" fill-rule="evenodd" d="M19.23 20.36a.85.85 0 1 0 1.54-.72c-1.192-2.553-3.527-4.485-6.36-5.195a5.5 5.5 0 1 0-4.82 0c-2.833.71-5.168 2.642-6.36 5.195a.85.85 0 1 0 1.54.72c1.238-2.65 4.002-4.51 7.23-4.51 3.228 0 5.992 1.86 7.23 4.51ZM12 13.3a3.8 3.8 0 1 1 0-7.6 3.8 3.8 0 0 1 0 7.6Z" clip-rule="evenodd"/></svg></span>
                                <span>Кабинет инвестора</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="header__bottom">
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
                </div>

            </div>
        </div>
    </header>

    <button class="button button_theme-white arrow-up__button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.9491 14L12.0097 10.0607L8.07037 14C7.77748 14.2929 7.3026 14.2929 7.00971 14C6.71682 13.7071 6.71682 13.2322 7.00971 12.9393L11.4794 8.46967C11.62 8.32902 11.8108 8.25 12.0097 8.25C12.2086 8.25 12.3994 8.32902 12.54 8.46967L17.0097 12.9393C17.3026 13.2322 17.3026 13.7071 17.0097 14C16.7168 14.2929 16.2419 14.2929 15.9491 14Z" fill="#4A66F5"/>
        </svg>
    </button>