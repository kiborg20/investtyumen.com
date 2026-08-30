<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<div class="container">
    <div class="container-form">
        <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
            <?
            if ($arResult["BACKURL"] <> '')
            {
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                <?
            }
            ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="SEND_PWD">
            <div class="container-form-header">
                <h1>Забыли пароль?</h1>
                <p>У меня уже есть аккаунт, <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a></p>
            </div>
            <div class="container-form-body">
                <div class="container-form-body-error">

                </div>
                <div class="container-form-body-input">
                    <input type="text" name="USER_LOGIN" placeholder="<?=GetMessage("sys_forgot_pass_login1")?>" value="<?=$arResult["USER_LOGIN"]?>" />
                    <input type="hidden" name="USER_EMAIL" />
                </div>
                <?if($arResult["PHONE_REGISTRATION"]):?>

                    <div class="container-form-body-input">
                        <input type="text" placeholder="<?=GetMessage("sys_forgot_pass_phone")?>" name="USER_PHONE_NUMBER" value="<?=$arResult["USER_PHONE_NUMBER"]?>" />
                    </div>
                    <?echo GetMessage("sys_forgot_pass_note_phone")?>
                <?endif;?>
                <?if($arResult["USE_CAPTCHA"]):?>
                    <div class="container-form-body-input">
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                    </div>
                    <div class="container-form-body-input">
                        <input placeholder="<?echo GetMessage("system_auth_captcha")?>" type="text" name="captcha_word" maxlength="50" value="" />
                    </div>
                <?endif?>
                <?echo GetMessage("sys_forgot_pass_note_email")?>
            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
                </div>
            </div>
        </form>

        <script type="text/javascript">
            document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
            document.bform.USER_LOGIN.focus();
        </script>
    </div>
</div>