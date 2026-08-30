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
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="container">
    <div class="container-form">


        <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" enctype="multipart/form-data">
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="REGISTRATION" />
            <div class="container-form-header">
                <h1><?=GetMessage("AUTH_REGISTER")?></h1>
                <p>У меня уже есть аккаунт, <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a></p>
            </div>
            <div class="container-form-body">
                <div class="container-form-body-error">
                    <?
                    ShowMessage($arParams["~AUTH_RESULT"]);
                    ShowMessage($arResult['ERROR_MESSAGE']);
                    ?>
                    <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
                    <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
                </div>
                <div class="container-form-body-input">
                    <input placeholder="Наименование компании или ИП" type="text" name="REGISTER[WORK_COMPANY]" maxlength="50" value="" class="bx-auth-input" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_NAME")?>" type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="bx-auth-input" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_LAST_NAME")?>" type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="bx-auth-input" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_LOGIN_MIN")?>" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="bx-auth-input" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?echo GetMessage("main_register_phone_number")?>" type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?=$arResult["USER_PHONE_NUMBER"]?>" class="bx-auth-input" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_EMAIL")?>" type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="bx-auth-input" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_PASSWORD_REQ")?>" type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
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
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_CONFIRM")?>" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
                </div>
                <?
                /* CAPTCHA */
                if ($arResult["USE_CAPTCHA"] == "Y") {
                    ?>
                    <div class="container-form-body-input">
                        <?=GetMessage("CAPTCHA_REGF_TITLE")?>
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
                    </div>
                    <?
                    }
                ?>
                <?// ********************* User properties ***************************************************?>
                <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
                <div class="container-form-body-input">

                    <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                        <?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;
                            ?><?=$arUserField["EDIT_FORM_LABEL"]?>:
                                <?$APPLICATION->IncludeComponent(
                            "bitrix:system.field.edit",
                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                            array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
                    <?endforeach;?>
                </div>
                <?endif;?>

            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="checkbox" id="confirm_reg" required checked >
                    <label for="confirm_reg">Я согласен на обработку <a href="">персональных даных</a></label>
                </div>
                <div class="container-form-footer-input">
                    <input type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER_btn")?>" />
                </div>
            </div>


        </form>
        <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b></b></a></p>

        <script type="text/javascript">
        document.bform.USER_NAME.focus();
        </script>

        </div>
    </div>
</div>