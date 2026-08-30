<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<div class="container">
    <div class="container-form">
        <h1>Регистрация</h1>
        <?if($USER->IsAuthorized()):?>

            <p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

        <?else:?>
        <?
        if (count($arResult["ERRORS"]) > 0):
            foreach ($arResult["ERRORS"] as $key => $error)
                if (intval($key) == 0 && $key !== 0)
                    $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

            ShowError(implode("<br />", $arResult["ERRORS"]));

        elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
        ?>
        <p>
            <a href="/auth/">Авторизация</a>
        </p>
        <p>
            Забыли пароль ? <a href="/auth/forgot/">Восстановление пароля</a>
        </p>
        <p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
        <?endif?>
        <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
            <?
                if($arResult["BACKURL"] <> ''):
                ?>
                    <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                <?
                endif;
                ?>

            <div class="container-form-body">
                <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>

                    <div class="container-form-body-input">

                                <?
                                switch ($FIELD)
                                {
                                    case "PASSWORD":
                                        ?>
                                        <input placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="bx-auth-input" />
                                        <?if($arResult["SECURE_AUTH"]):?>
                                            <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                                                <div class="bx-auth-secure-icon"></div>
                                            </span>
                                            <noscript>
                                            <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                                                <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                            </span>
                                            </noscript>
                                            <script type="text/javascript">
                                            document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                            </script>
                                        <?endif?>
                                    <?
                                        break;
                                    case "CONFIRM_PASSWORD":
                                        ?><input placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" /><?
                                        break;

                                    case "PERSONAL_GENDER":
                                        ?><select name="REGISTER[<?=$FIELD?>]">
                                            <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                                            <option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                                            <option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                                        </select><?
                                        break;

                                    case "PERSONAL_COUNTRY":
                                    case "WORK_COUNTRY":
                                        ?><select name="REGISTER[<?=$FIELD?>]"><?
                                        foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
                                        {
                                            ?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
                                        <?
                                        }
                                        ?></select><?
                                        break;

                                    case "PERSONAL_PHOTO":
                                    case "WORK_LOGO":
                                        ?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" /><?
                                        break;

                                    case "PERSONAL_NOTES":
                                    case "WORK_NOTES":
                                        ?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea><?
                                        break;
                                    default:
                                        if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
                                        ?><input placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
                                            if ($FIELD == "PERSONAL_BIRTHDAY")
                                                $APPLICATION->IncludeComponent(
                                                    'bitrix:main.calendar',
                                                    '',
                                                    array(
                                                        'SHOW_INPUT' => 'N',
                                                        'FORM_NAME' => 'regform',
                                                        'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                                        'SHOW_TIME' => 'N'
                                                    ),
                                                    null,
                                                    array("HIDE_ICONS"=>"Y")
                                                );
                                            ?><?
                                    }?>
                            </div>

                <?endforeach?>

                <?// ******************** /User properties ***************************************************?>
                <?
                /* CAPTCHA */
                if ($arResult["USE_CAPTCHA"] == "Y")
                {
                    ?>
                    <div class="container-form-body-input">
                        <?=GetMessage("REGISTER_CAPTCHA_TITLE")?>
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span>
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
                    </div>
                    <?
                }
                /* !CAPTCHA */
            ?>
            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
                </div>
            </div>
        </form>

        <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>

        <?endif //$arResult["SHOW_SMS_FIELD"] == true ?>

        <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
    </div>
</div>