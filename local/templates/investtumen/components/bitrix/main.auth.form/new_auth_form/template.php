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
	echo Loc::getMessage('MAIN_AUTH_FORM_SUCCESS');
	return;
}
?>

<div class="container">
    <div class="container-form">



	<?if ($arResult['AUTH_SERVICES']):?>
		<?$APPLICATION->IncludeComponent('bitrix:socserv.auth.form',
			'flat',
			array(
				'AUTH_SERVICES' => $arResult['AUTH_SERVICES'],
				'AUTH_URL' => $arResult['CURR_URI']
	   		),
			$component,
			array('HIDE_ICONS' => 'Y')
		);
		?>
		<hr class="bxe-light">
	<?endif?>

	<form name="<?= $arResult['FORM_ID'];?>" method="post" target="_top" action="<?= POST_FORM_ACTION_URI;?>">
        <div class="container-form-header">
            <h1><?= Loc::getMessage('MAIN_AUTH_FORM_HEADER');?></h1>
            <p>У меня ещё нет аккаунта,
                <a href="<?= $arResult['AUTH_REGISTER_URL'];?>" rel="nofollow">
                    <?= Loc::getMessage('MAIN_AUTH_FORM_URL_REGISTER_URL');?>
                </a>
            </p>
            <p>
                <a href="<?= $arResult['AUTH_FORGOT_PASSWORD_URL'];?>" rel="nofollow">
                    <?= Loc::getMessage('MAIN_AUTH_FORM_URL_FORGOT_PASSWORD');?>
                </a>
            </p>
        </div>
        <?if ($arResult['ERRORS']):?>
            <div class="alert alert-danger">
                <? foreach ($arResult['ERRORS'] as $error)
                {
                    echo $error;
                }
                ?>
            </div>
        <?endif;?>
        <div class="container-form-body">
            <div class="container-form-body-input">
                <input placeholder="Ваш login" type="text" name="<?= $arResult['FIELDS']['login'];?>" maxlength="255" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>" />
            </div>

            <div class="container-form-body-input">
                <input placeholder="Ваш пароль" type="password" name="<?= $arResult['FIELDS']['password'];?>" maxlength="255" autocomplete="off" />
            </div>
            <div class="container-form-body-input">
                <?if ($arResult['CAPTCHA_CODE']):?>
                    <input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" />
                    <div class="bx-authform-formgroup-container dbg_captha">
                        <div class="bx-authform-label-container">
                            <?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_CAPTCHA');?>
                        </div>
                        <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" width="180" height="40" alt="CAPTCHA" /></div>
                        <div class="bx-authform-input-container">
                            <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
                        </div>
                    </div>
                <?endif;?>
            </div>
            <?if ($arResult['STORE_PASSWORD'] == 'Y'):?>
                <div class="container-form-body-input">
                    <label class="bx-filter-param-label">
                        <input type="checkbox" checked id="USER_REMEMBER" name="<?= $arResult['FIELDS']['remember'];?>" value="Y" />
                        <span class="bx-filter-param-text"><?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_REMEMBER');?></span>
                    </label>
                </div>
            <?endif?>

        </div>
        <div class="container-form-footer">
            <div class="container-form-footer-input">
                <input type="submit" class="btn btn-primary" name="<?= $arResult['FIELDS']['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_SUBMIT');?>" />
            </div>
        </div>
	</form>
</div>

<script type="text/javascript">
	<?if ($arResult['LAST_LOGIN'] != ''):?>
	try{document.<?= $arResult['FORM_ID'];?>.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
	try{document.<?= $arResult['FORM_ID'];?>.USER_LOGIN.focus();}catch(e){}
	<?endif?>
</script>