<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex" />
    <meta name="google-site-verification" content="XvOMIVsmIlmjRVbfJ3Eb_0K1V02dYd2W4NqDVycUP0Q" />
    <title><? $APPLICATION->ShowTitle(false); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <? $APPLICATION->ShowHead(); ?>

</head>

<body>
    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>
    <header>
        <div class="container headerwrap">
            <a href="/" class="headerlogo">
                <img src="/img/logowhite.svg" alt="Инвест Тюмень">
                <img class="logomobile" src="/img/logomobile.svg" alt="Tyumen">
            </a>
            <div class="headerright">
                <div class="firstrow">
                    <div class="logotext">Investment portal of the Tyumen region</div>
                    <div class="phone">
                        <p>Russia</p>
                        <a href="tel:+78005500830">8 800 550-08-30</a>
                    </div>
                    <a href="#" class="roundbtn headerbutton btnwhite">Связаться</a>
                    <div class="btnblock">
                        <div class="langbtn">
                            <a href="https://investintyumen.ru/" class="ru  toru">RU</a> / <a href="https://en.investintyumen.ru" class="en activelang toeng">EN</a>
                        </div>
                        <a href="" class="searchbtn"></a>
                    </div>
                </div>
                <div class="secondrow">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "headermenu",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "COMPONENT_TEMPLATE" => ".default",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => "",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                </div>
                <div class="burger"></div>
            </div>
            <div class="mobilemenu">
                <div class="langbtn">
                    <a href="https://investintyumen.ru" class="ru  toru">RU</a> / <a href="https://en.investintyumen.ru" class="en activelang toeng">EN</a>
                </div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "headermobilemenu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "COMPONENT_TEMPLATE" => ".default",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => "",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "N"
                    )
                ); ?>
                <div class="roundbtn">Contact</div>
            </div>
        </div>
    </header>