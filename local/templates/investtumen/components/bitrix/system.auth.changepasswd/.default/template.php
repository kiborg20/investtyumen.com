<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?php
if($arResult["PHONE_REGISTRATION"])
{
	CJSCore::Init('phone_auth');
}
?>
<div class="container">
    <div class="container-form">

    <?if($arResult["SHOW_FORM"]):?>

    <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
        <?if ($arResult["BACKURL"] <> ''): ?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <? endif ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="CHANGE_PWD">
        <div class="container-form-header">
            <h1><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h1>
            <p>У меня уже есть аккаунт, <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a></p>
        </div>
        <div class="container-form-body">
            <div class="container-form-body-error">
                <?ShowError("error")?>
                <?
                ShowMessage($arParams["~AUTH_RESULT"]);
                ShowMessage($arResult['ERROR_MESSAGE']);
                ?>
            </div>
            <div class="container-form-body-input">
                <?if($arResult["USE_CAPTCHA"]):?>
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <span class="starrequired">*</span><?echo GetMessage("system_auth_captcha")?>
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
                <?endif?>
            </div>
            <div class="container-form-body-input">

            </div>
        </div>
        <div class="container-form-footer">
            <div class="container-form-footer-input">

            </div>
        </div>

    <?if($arResult["PHONE_REGISTRATION"]):?>
                <tr>
                    <td><?echo GetMessage("sys_auth_chpass_phone_number")?></td>
                    <td>
                        <input type="text" value="<?=htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"])?>" class="bx-auth-input" disabled="disabled" />
                        <input type="hidden" name="USER_PHONE_NUMBER" value="<?=htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"])?>" />
                    </td>
                </tr>
                <tr>
                    <td><span class="starrequired">*</span><?echo GetMessage("sys_auth_chpass_code")?></td>
                    <td><input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" autocomplete="off" /></td>
                </tr>
    <?else:?>
                <tr>
                    <td><span class="starrequired">*</span><?=GetMessage("AUTH_LOGIN")?></td>
                    <td><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="bx-auth-input" /></td>
                </tr>
    <?
        if($arResult["USE_PASSWORD"]):
    ?>
                <tr>
                    <td><span class="starrequired">*</span><?echo GetMessage("sys_auth_changr_pass_current_pass")?></td>
                    <td><input type="password" name="USER_CURRENT_PASSWORD" maxlength="255" value="<?=$arResult["USER_CURRENT_PASSWORD"]?>" class="bx-auth-input" autocomplete="new-password" /></td>
                </tr>
    <?
        else:
    ?>
                <tr>
                    <td><span class="starrequired">*</span><?=GetMessage("AUTH_CHECKWORD")?></td>
                    <td><input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" autocomplete="off" /></td>
                </tr>
    <?
        endif
    ?>
    <?endif?>
                <tr>
                    <td><span class="starrequired">*</span><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></td>
                    <td><input type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="new-password" />
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
                    </td>
                </tr>
                <tr>
                    <td><span class="starrequired">*</span><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?></td>
                    <td><input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="new-password" /></td>
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td><input type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" /></td>
                </tr>
            </tfoot>
        </table>
    </form>

    <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
    <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>

    <?if($arResult["PHONE_REGISTRATION"]):?>

    <script type="text/javascript">
    new BX.PhoneAuth({
        containerId: 'bx_chpass_resend',
        errorContainerId: 'bx_chpass_error',
        interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
        data:
            <?=CUtil::PhpToJSObject([
                'signedData' => $arResult["SIGNED_DATA"]
            ])?>,
        onError:
            function(response)
            {
                var errorDiv = BX('bx_chpass_error');
                var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                errorNode.innerHTML = '';
                for(var i = 0; i < response.errors.length; i++)
                {
                    errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                }
                errorDiv.style.display = '';
            }
    });
    </script>

    <div id="bx_chpass_error" style="display:none"></div>

    <div id="bx_chpass_resend"></div>

    <?endif?>

    <?endif?>

    <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?>
    </div>
</div>