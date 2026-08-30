<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//here you can place your own messages
	switch($arResult["MESSAGE_CODE"])
	{
	case "E01":
		?><? //When user not found
		break;
	case "E02":
		?><? //User was successfully authorized after confirmation
		break;
	case "E03":
		?><? //User already confirm his registration
		break;
	case "E04":
		?><? //Missed confirmation code
		break;
	case "E05":
		?><? //Confirmation code provided does not match stored one
		break;
	case "E06":
		?><? //Confirmation was successfull
		break;
	case "E07":
		?><? //Some error occured during confirmation
		break;
	}
?>
<?if($arResult["SHOW_FORM"]):?>
<div class="container">
    <div class="container-form">
	    <form method="post" action="<?echo $arResult["FORM_ACTION"]?>">
            <div class="container-form-header">
                <h1><?echo GetMessage("CT_BSAC_LOGIN")?>:</h1>
                <p><?echo $arResult["MESSAGE_TEXT"]?></p>
            </div>
            <div class="container-form-body">
                <div class="container-form-body-input">
                    <input type="text" placeholder="Ваш Login" name="<?echo $arParams["LOGIN"]?>" maxlength="50" value="<?echo $arResult["LOGIN"]?>" size="17" />
                </div>
                <div class="container-form-body-input">
                    <input type="text" placeholder="<?echo GetMessage("CT_BSAC_CONFIRM_CODE")?>" name="<?echo $arParams["CONFIRM_CODE"]?>" maxlength="50" value="<?echo $arResult["CONFIRM_CODE"]?>" size="17" />
                </div>
            </div>
            <div class="container-form-footer">
                <div class="container-form-footer-input">
                    <input type="submit" value="<?echo GetMessage("CT_BSAC_CONFIRM")?>" />
                </div>
            </div>
            <input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />
	    </form>
    </div>
</div>
<?elseif(!$USER->IsAuthorized()):?>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", array());?>
<?endif?>