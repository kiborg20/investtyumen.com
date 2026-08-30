<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
//CJSCore::init(['jquery2']);
$this->addExternalCss("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css");
$this->addExternalJS("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js");

$this->addExternalCss(SITE_TEMPLATE_PATH . "/js/select2/dist/css/select2.min.css");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/select2/dist/js/select2.full.js");
?>

<div class="formtext"><?= $arResult['DESCRIPTION'] ?></div>
<?
$js_data = [
    "iblock_id" => $arParams["IBLOCK_ID"],
    'ajaxpath' => $componentPath . '/ajax-calendar.php',
    'mask' => '+7(999)999-99-99'
];

$curUser = Cinvestments::getCurUserData();

$phone = "";
if($curUser["PERSONAL_PHONE"]!=""){$phone = $curUser["PERSONAL_PHONE"];}else{$phone = $curUser["PERSONAL_MOBILE"];}

$curUserjs = [
    "name"=>$curUser["LAST_NAME"]." ".$curUser["NAME"]." ".$curUser["SECOND_NAME"],
    "phone"=>$phone,
    "email"=>$curUser["EMAIL"]
];

?>
<script>
    var fparams = <?=CUtil::PhpToJSObject($js_data)?>;
    var curuser = <?=CUtil::PhpToJSObject($curUserjs)?>;
</script>


<form action="#" class="infoblock_form" id="infoblock_form" enctype="multipart/form-data">
    <div class="form_fieldset">
        <label for="EVENT_NAME"
               class="formlabel ">Мероприятие</label>

        <input type='text'
               class="event_name"
               name='EVENT_NAME'
               value="<?=$arParams["EVENT"]["EVENT_NAME"]?>"
        >
        <input type='hidden'
               class="event_theme"
               name='EVENT_THEME'
               value="<?=$arParams["EVENT"]["EVENT_THEME"]?>"
        >
        <input type='hidden'
               class="event_date"
               name='EVENT_DATE'
               value="<?=$arParams["EVENT"]["EVENT_DATE"]?>"
        >
        <input type='hidden'
               class="event_time"
               name='EVENT_TIME'
               value="<?=$arParams["EVENT"]["EVENT_TIME"]?>"
        >
        <input type='hidden'
               class="event_place"
               name='EVENT_PLACE'
               value="<?=$arParams["EVENT"]["EVENT_PLACE"]?>"
        >
        <input type='hidden'
               class="iblockID"
               name='iblockID'
               value="<?=$arParams["IBLOCK_ID"]?>"
        >
    </div>
    <div class="form_fieldset">
        <label for="INITIATOR"
               class="formlabel required_field">Компания</label>

        <input type='text'
               class="initiator"
               name='INITIATOR'
               value='<?=$curUser["WORK_COMPANY"]?>'
               required
        >
    </div>
    <div class="form_fieldset">
        <label for="INITIATOR_INN"
               class="formlabel required_field ">ИНН инициатора</label>
        <input type='text'
               class="initiator_inn"
               name='INITIATOR_INN'
               value="<?=$curUser["UF_INN"]?>"
               required
        >
    </div>

<!--    <div class="form_fieldset">-->
<!--        <label for="USERCOUNT" class="formlabel required_field ">Количество участников</label>-->
<!--        <input type='number' class="usercount" name='USERCOUNT' value="1" >-->
<!--    </div>-->

    <div class="form_fieldset checkbox_fieldset">
        <input type='checkbox' class="inoe_lico" name='INOELICO' id='INOELICO' value="yes">
        <label for="INOELICO" class="formlabel ">Участник иное лицо</label>
    </div>

    <div class="contacts_wrapper">
        <div class="contactblock first_contact">
            <div class="form_fieldset">
                <label for="" class="formlabel required_field ">Участник</label>
                <input type='text' class="username" name='USERNAME[]' value="<?=$curUser["LAST_NAME"]." ".$curUser["NAME"]." ".$curUser["SECOND_NAME"];?>" required >
            </div>
            <div class="form_fieldset">
                <label for="" class="formlabel required_field ">Телефон</label>
                <input type='text' class="phonefield userphone" name='USERPHONE[]' value="<?if($curUser["PERSONAL_PHONE"]!=""){echo $curUser["PERSONAL_PHONE"];}else{$curUser["PERSONAL_MOBILE"];}?>" required >
            </div>
            <div class="form_fieldset">
                <label for="" class="formlabel required_field ">Электронная почта</label>
                <input type='text' class="useremail" name='USEREMAIL[]' value="<?=$curUser["EMAIL"];?>" required >
            </div>
        </div>
    </div>
    <div class="dop_contacts_wrapper">

    </div>

    <div class="form_fieldset flex-center">
        <input type="submit" class="formsubmit btn " value="Отправить">
        <a href="#" class="adduser">Добавить участника</a>
    </div>

    <?if($arResult["FILES"]!=""):?>
        <div class="form_fieldset">
           <h2 class="docsheader">Скачайте шаблоны документов</h2>
            <?=$arResult["FILES"]?>
        </div>

    <?endif;?>

</form>



