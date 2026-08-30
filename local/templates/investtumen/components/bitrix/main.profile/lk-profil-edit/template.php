<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss("/bitrix/css/main/font-awesome.min.css");

?>

<div class="personal-view">
    <h1>Редактирование личных данных</h1>
    <?ShowError($arResult["strProfileError"]);?>
    <?
    if ($arResult['DATA_SAVED'] == 'Y')
//        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
        LocalRedirect('/personal/');
    ?>
    <script type="text/javascript">
        <!--
        var opened_sections = [<?
        $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
        $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
        if ($arResult["opened"] <> '')
        {
            echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
        }
        else
        {
            $arResult["opened"] = "reg";
            echo "'reg'";
        }
        ?>];
        //-->

        var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
    </script>
    <form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
        <?=$arResult["BX_SESSION_CHECK"]?>
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
        <input type="checkbox" class="input_check_del" name="PERSONAL_PHOTO_del" value="Y" id="PERSONAL_PHOTO_del">
        <div class="personal-view-wrap-img">
            <? if ($arResult['arUser']['PERSONAL_PHOTO_HTML']) {
                echo $arResult['arUser']['PERSONAL_PHOTO_HTML'];
                ?>
                
                <?
            }
                $firstLetter = mb_substr(strval($USER->GetFirstName()) , 0 , 1);
                ?>
                <div class="personal-view-wrap-img-del" style="<?=($arResult['arUser']['PERSONAL_PHOTO_HTML'])? '' : 'display:none'?>">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </div>
                <span style="<?=($arResult['arUser']['PERSONAL_PHOTO_HTML'])? 'display:none' : ''?>"><?=$firstLetter?></span>
                <?
            ?>
        </div>

        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                Изображение пользователя
            </div>
            <div class="personal-view-wrap-value">

                <label class="input_file" for="file_personal">
                    <input id="file_personal" value="<?=$arResult['arUser']['PERSONAL_PHOTO']?>" name="PERSONAL_PHOTO" class="typefile" size="20" type="file">
                    Выберите файл
                </label>
            </div>
        </div>


        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                Наименование компании
            </div>
            <div class="personal-view-wrap-value">
                <input type="text" name="WORK_COMPANY" maxlength="255" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" />
            </div>
        </div>
        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                Фамилия
            </div>
            <div class="personal-view-wrap-value">
                <input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
            </div>
        </div>
        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                Имя
            </div>
            <div class="personal-view-wrap-value">
                <input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
            </div>
        </div>
        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                Отчество
            </div>
            <div class="personal-view-wrap-value">
                <input type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
            </div>
        </div>
        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                Номер телефона
            </div>
            <div class="personal-view-wrap-value">
                <input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
            </div>
        </div>
        <div class="personal-view-wrap">
            <div class="personal-view-wrap-title">
                E-mail
            </div>
            <div class="personal-view-wrap-value">
                <input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
            </div>
        </div>
        <?if($arResult['CAN_EDIT_PASSWORD']):?>
            <div class="personal-view-wrap">
                <div class="personal-view-wrap-title">
                    <?=GetMessage('NEW_PASSWORD_REQ')?>
                </div>
                <div class="personal-view-wrap-value">
                    <input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="bx-auth-input" />
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
            </div>
            <div class="personal-view-wrap">
                <div class="personal-view-wrap-title">
                    <?=GetMessage('NEW_PASSWORD_CONFIRM')?>
                </div>
                <div class="personal-view-wrap-value">
                    <input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
                </div>
            </div>
        <?endif?>
        <div class="personal-view-edit">
            <input type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
        </div>
    </form>
</div>