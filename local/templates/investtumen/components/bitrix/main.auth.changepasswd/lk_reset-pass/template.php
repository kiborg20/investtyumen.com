<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\Bitrix\Main\Page\Asset::getInstance()->addCss(
	'/bitrix/css/main/system.auth/flat/style.css'
);

if ($arResult['AUTHORIZED'])
{
	echo Loc::getMessage('MAIN_AUTH_CHD_SUCCESS');
	return;
}

$fields = $arResult['FIELDS'];
?>

<div class="container">
    <div class="container-form">

        <?if ($arResult['ERRORS']):?>
        <div class="alert alert-danger">
            <? foreach ($arResult['ERRORS'] as $error)
            {
                echo $error;
            }
            ?>
        </div>
        <?elseif ($arResult['SUCCESS']):?>
        <div class="alert alert-success">
            <?= $arResult['SUCCESS'];?>
        </div>
        <?endif;?>
        <form name="bform" method="post" target="_top" action="<?= POST_FORM_ACTION_URI;?>">
            <div class="container-form-header">
                <h1><?= Loc::getMessage('MAIN_AUTH_CHD_HEADER');?></h1>
                <p>
                    <a href="/auth/" rel="nofollow">
                        Авторизация
                    </a>
                </p>
                <p>У меня ещё нет аккаунта,
                    <a href="/auth/registration/" rel="nofollow">
                        Регистрация
                    </a>
                </p>
                <?if ($arResult['ERRORS']):?>
                    <div class="alert alert-danger">
                        <? foreach ($arResult['ERRORS'] as $error)
                        {
                            echo $error;
                        }
                        ?>
                    </div>
                <?elseif ($arResult['SUCCESS']):?>
                    <div class="alert alert-success">
                        <?= $arResult['SUCCESS'];?>
                    </div>
                <?endif;?>
            </div>
            <div class="container-form-body">
                <div class="container-form-body-input">
                    <input placeholder="<?= Loc::getMessage('MAIN_AUTH_CHD_FIELD_LOGIN');?>" type="text" name="<?= $fields['login'];?>" maxlength="255" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>" />
                </div>
                <div class="container-form-body-input">
                    <input placeholder="<?= Loc::getMessage('MAIN_AUTH_CHD_FIELD_CHECKWORD');?>" type="text" name="<?= $fields['checkword'];?>" maxlength="255" value="<?= \htmlspecialcharsbx($arResult[$fields['checkword']]);?>" />
                </div>
                <?= Loc::getMessage('MAIN_AUTH_CHD_SECURE_NOTE');?>
                <div class="container-form-body-input">
                    <?if ($arResult['SECURE_AUTH']):?>
                        <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
                            <div class="bx-authform-psw-protected-desc"><span></span>
                                <?= Loc::getMessage('MAIN_AUTH_CHD_SECURE_NOTE');?>
                            </div>
                        </div>
                        <script type="text/javascript">
                            document.getElementById('bx_auth_secure').style.display = '';
                        </script>
                    <?endif;?>
                    <input placeholder="<?= Loc::getMessage('MAIN_AUTH_CHD_FIELD_PASS');?>" type="password" name="<?= $fields['password'];?>" value="<?= \htmlspecialcharsbx($arResult[$fields['password']]);?>" maxlength="255" autocomplete="off" />
                </div>
                <div class="container-form-body-input">
                    <?if ($arResult['SECURE_AUTH']):?>
                        <div class="bx-authform-psw-protected" id="bx_auth_secure2" style="display:none">
                            <div class="bx-authform-psw-protected-desc"><span></span>
                                <?= Loc::getMessage('MAIN_AUTH_CHD_SECURE_NOTE');?>
                            </div>
                        </div>
                        <script type="text/javascript">
                            document.getElementById('bx_auth_secure2').style.display = '';
                        </script>
                    <?endif;?>
                    <input placeholder="Повторите пароль" type="password" name="<?= $fields['confirm_password'];?>" value="<?= \htmlspecialcharsbx($arResult[$fields['confirm_password']]);?>" maxlength="255" autocomplete="off" />
                </div>
                <?if ($arResult['CAPTCHA_CODE']):?>
                    <div class="container-form-body-input">
                        <input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" />
                        <div class="bx-authform-formgroup-container dbg_captha">
                            <div class="bx-authform-label-container">
                                <?= Loc::getMessage('MAIN_AUTH_CHD_FIELD_CAPTCHA');?>
                            </div>
                            <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" width="180" height="40" alt="CAPTCHA" /></div>
                            <div class="bx-authform-input-container">
                                <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <?= $arResult['GROUP_POLICY']['PASSWORD_REQUIREMENTS'];?>
            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="submit" class="btn btn-primary" name="<?= $fields['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_CHD_FIELD_SUBMIT');?>" />
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	document.bform.<?= $fields['login'];?>.focus();
</script>
