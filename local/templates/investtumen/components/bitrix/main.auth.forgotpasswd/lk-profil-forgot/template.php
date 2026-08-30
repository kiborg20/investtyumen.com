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
	echo Loc::getMessage('MAIN_AUTH_PWD_SUCCESS');
	return;
}
?>

<div class="container">
    <div class="container-form">
        <form name="bform" method="post" target="_top" action="<?= POST_FORM_ACTION_URI;?>">
            <div class="container-form-header">
                <h1>Восстановление пароля</h1>
                <p><a href="/auth/">Авторизоваться</a></p>
                <p>
                    У меня ещё нет аккаунта, <a href="/auth/registration/">зарегистрироваться</a>
                </p>
                <p class="bx-authform-content-container"><?= Loc::getMessage('MAIN_AUTH_PWD_NOTE');?></p>
            </div>
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
            <div class="container-form-body">
                <div class="container-form-body-input">
                    <input placeholder="<?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_LOGIN');?>" type="text" name="<?= $arResult['FIELDS']['login'];?>" maxlength="255" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>" />
                </div>
                <span class="login-label"><?= Loc::getMessage('MAIN_AUTH_PWD_OR');?></span>
                <div class="container-form-body-input">
                    <input placeholder="<?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_EMAIL');?>" type="text" name="<?= $arResult['FIELDS']['email'];?>" maxlength="255" value="" />
                </div>
                <?if ($arResult['CAPTCHA_CODE']):?>
                    <input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" />
                    <?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_CAPTCHA');?>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" width="180" height="40" alt="CAPTCHA" />
                    <div class="container-form-body-input">
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
                    </div>
                <?endif;?>
            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="submit" class="btn btn-primary" name="<?= $arResult['FIELDS']['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_SUBMIT');?>" />
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	document.bform.<?= $arResult['FIELDS']['login'];?>.focus();
</script>
