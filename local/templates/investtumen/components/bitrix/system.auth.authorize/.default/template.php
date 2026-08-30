<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="container">
    <div class="container-form">
        <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />
            <?if ($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>
            <div class="container-form-header">
                <h1>вход</h1>
                <p>У меня ещё нет аккаунта, <a href="/auth/registration/">зарегистрироваться</a>
                    <a href="/auth/forgot/">Забыли свой пароль?</a>
                </p>
            </div>
            <div class="container-form-body">
                <div class="container-form-body-error">
                <?
                    ShowMessage($arParams["~AUTH_RESULT"]);
                    ShowMessage($arResult['ERROR_MESSAGE']);
                ?>
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_LOGIN")?>" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>">
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?=GetMessage("AUTH_PASSWORD")?>" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
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
                <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
                    <div class="container-form-body-input">
                        <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
                        <label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label>
                    </div>
                <?endif?>
                <?if($arResult["CAPTCHA_CODE"]):?>
                    <div class="container-form-body-input">
                        <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:</td>
                        <input class="bx-auth-input form-control" type="text" name="captcha_word" maxlength="50" value="" size="15" autocomplete="off" />
                    </div>
                <?endif;?>
            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
                </div>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript">
<?if ($arResult["LAST_LOGIN"] <> ''):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

