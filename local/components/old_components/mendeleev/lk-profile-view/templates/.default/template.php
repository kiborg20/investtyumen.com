<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="personal-view">
    <h1>Личный кабинет</h1>
    <div class="personal-view-wrap-img">
        <? if ($arResult['PERSONAL_PHOTO']) {
            ?>
                <img src="<?=CFile::GetPath($arResult['PERSONAL_PHOTO'])?>" alt="">
            <?
        } else {
            $firstLetter = mb_substr(strval($USER->GetFirstName()) , 0 , 1);
            ?>
                <span><?=$firstLetter?></span>
            <?
        }

        ?>
    </div>
    <div class="personal-view-wrap">
        <div class="personal-view-wrap-title">
            Наименование компании
        </div>
        <div class="personal-view-wrap-value">
            <?=$arResult['WORK_COMPANY']?>
        </div>
    </div>
    <div class="personal-view-wrap">
        <div class="personal-view-wrap-title">
            Фамилия
        </div>
        <div class="personal-view-wrap-value">
            <?=$arResult['LAST_NAME']?>
        </div>
    </div>
    <div class="personal-view-wrap">
        <div class="personal-view-wrap-title">
            Имя
        </div>
        <div class="personal-view-wrap-value">
            <?=$arResult['NAME']?>
        </div>
    </div>
    <div class="personal-view-wrap">
        <div class="personal-view-wrap-title">
            Отчество
        </div>
        <div class="personal-view-wrap-value">
            <?=$arResult['SECOND_NAME']?>
        </div>
    </div>
    <div class="personal-view-wrap">
        <div class="personal-view-wrap-title">
            Номер телефона
        </div>
        <div class="personal-view-wrap-value">
            <?=$arResult['PERSONAL_PHONE']?>
        </div>
    </div>
    <div class="personal-view-wrap">
        <div class="personal-view-wrap-title">
            E-mail
        </div>
        <div class="personal-view-wrap-value">
            <?=$arResult['EMAIL']?>
        </div>
    </div>
    <div class="personal-view-edit">
        <a href="/personal/edit/">Редактировать</a>
    </div>
</div>

<?php