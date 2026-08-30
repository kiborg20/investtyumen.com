<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}


//echo "<pre>";
//var_dump($arResult);
//echo "</pre>";
?>

<div class="bx-auth-profile">

    <? ShowError($arResult["strProfileError"]); ?>
    <?
    if ($arResult['DATA_SAVED'] == 'Y')
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?>

    <? if ($arResult["SHOW_SMS_FIELD"] == true): ?>

        <form method="post" action="<?= $arResult["FORM_TARGET"] ?>">
            <?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>"/>
            <table class="profile-table data-table">
                <tbody>
                <tr>
                    <td><? echo GetMessage("main_profile_code") ?><span class="starrequired">*</span></td>
                    <td><input size="30" type="text" name="SMS_CODE"
                               value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off"/></td>
                </tr>
                </tbody>
            </table>

            <p><input type="submit" name="code_submit_button" value="<? echo GetMessage("main_profile_send") ?>"/></p>

        </form>

        <script>
            new BX.PhoneAuth({
                containerId: 'bx_profile_resend',
                errorContainerId: 'bx_profile_error',
                interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
                data:
                <?=CUtil::PhpToJSObject([
                    'signedData' => $arResult["SIGNED_DATA"],
                ])?>,
                onError:
                    function (response) {
                        var errorDiv = BX('bx_profile_error');
                        var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                        errorNode.innerHTML = '';
                        for (var i = 0; i < response.errors.length; i++) {
                            errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                        }
                        errorDiv.style.display = '';
                    }
            });
        </script>

        <div id="bx_profile_error" style="display:none"><? ShowError("error") ?></div>

        <div id="bx_profile_resend"></div>

    <? else: ?>

        <script type="text/javascript">
            <!--
            var opened_sections = [<?
                $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"] . "_user_profile_open"];
                $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
                if ($arResult["opened"] <> '') {
                    echo "'" . implode("', '", explode(",", $arResult["opened"])) . "'";
                } else {
                    $arResult["opened"] = "reg";
                    echo "'reg'";
                }
                ?>];
            //-->

            var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
        </script>
        <form method="post" class="infoblock_form" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
            <?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>

            <ul class="tabs_block" uk-tab uk-switcher="swiping:false">
                <li class="uk-active"><a href="#">Личные данные</a></li>
                <li class="uk-active"><a href="#">Организация</a></li>
                <li><a href="#">Регистрационная информация</a></li>
            </ul>
            <!-- This is the container of the content items -->
            <ul class="uk-switcher">
                <li class="switcher_container">
                    <div class="flex_full avatartcont">

                            <?
                            if ($arResult["arUser"]["PERSONAL_PHOTO"] <> '')
                            {
                                ?>
                                <?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"]?>
                                <div class="form_fieldset">
                                    <input type="checkbox" name="PERSONAL_PHOTO_del" value="Y" id="PERSONAL_PHOTO_del">
                                    <label for="PERSONAL_PHOTO_del">Удалить фото</label>
                                </div>
                                <?
                            }else{
                            ?>
                                <div class="form_fieldset">
                                    <div class="avatarbox">
                                        <img id="avatar" src="/local/templates/investtumen/img/nophoto.jpg" alt="">
                                    </div>
                                    <?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
                                    <label for="PERSONAL_PHOTO" class="fileinputlabel">
                                        <span>Загрузить фото</span>
                                    </label>
                                </div>
                            <?}?>


                            <div class="form_fieldset">
                                <label for="LAST_NAME" class="formlabel"><?= GetMessage('LAST_NAME') ?></label>
                                <input type="text" name="LAST_NAME" maxlength="50" value="<?= $arResult["arUser"]["LAST_NAME"] ?>"/>
                            </div>
                            <div class="form_fieldset">
                                <label for="NAME" class="formlabel"><?= GetMessage('NAME') ?></label>
                                <input type="text" name="NAME" maxlength="50"
                                       value="<?= $arResult["arUser"]["NAME"] ?>"/>
                            </div>
                            <div class="form_fieldset">
                                <label for="NAME" class="formlabel"><?= GetMessage('SECOND_NAME') ?></label>
                                <input type="text" name="SECOND_NAME" maxlength="50"
                                       value="<?= $arResult["arUser"]["SECOND_NAME"] ?>"/>
                            </div>
                            <?/*<?$first = true;?>
                            <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>

                                <div class="form_fieldset">
                                    <label for="" class="formlabel <?if ($arUserField["MANDATORY"]=="Y"){echo 'required_field';}?>"><?=$arUserField["EDIT_FORM_LABEL"]?></label>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:system.field.edit",
                                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?>
                                </div>
                            <?endforeach;?>*/?>

                    </div>

                    <div class="flex_full">

                            <div class="form_fieldset">
                                <label for="NAME" class="formlabel"><?= GetMessage('EMAIL') ?><? if ($arResult["EMAIL_REQUIRED"]): ?><span
                                            class="starrequired">*</span><? endif ?></label>
                                <input type="text" name="EMAIL" maxlength="50"
                                       value="<? echo $arResult["arUser"]["EMAIL"] ?>"/>
                            </div>
                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?=GetMessage('USER_PHONE')?></label>
                                <input class="phonefield" type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
                            </div>

                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?=GetMessage('USER_MOBILE')?></label>
                                <input class="phonefield" type="text" name="PERSONAL_MOBILE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_MOBILE"]?>" />
                            </div>
                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?=GetMessage('USER_WWW')?></label>
                                <input type="text" name="WORK_WWW" maxlength="255" value="<?=$arResult["arUser"]["WORK_WWW"]?>" />
                            </div>

                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?=GetMessage('USER_COUNTRY')?></label>
                                <?=$arResult["COUNTRY_SELECT"]?>
                            </div>

                            <div class="form_fieldset">
                                <label for="" class="formlabel ">Регион:</label>
                                <?echo Cinvestments::getRegionSelect($arResult["arUser"]["PERSONAL_STATE"],"PERSONAL_STATE");?>
                                <?/*<input type="text" name="PERSONAL_STATE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_STATE"]?>" />*/?>
                            </div>

                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?=GetMessage('USER_CITY')?></label>
                                <input type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" />
                            </div>

                    </div>
                </li>
                <li class="switcher_container">
                    <div class="flex_full">

                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?=GetMessage('USER_COMPANY')?></label>
                            <input type="text" name="WORK_COMPANY" maxlength="255" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" />
                        </div>
                        <?$first = true;?>
                        <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>

                            <div class="form_fieldset">
                                <label for="" class="formlabel <?if ($arUserField["MANDATORY"]=="Y"){echo 'required_field';}?>"><?=$arUserField["EDIT_FORM_LABEL"]?></label>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:system.field.edit",
                                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?>
                            </div>
                        <?endforeach;?>
                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?=GetMessage('USER_DEPARTMENT')?></label>
                            <input type="text" name="WORK_DEPARTMENT" maxlength="255" value="<?=$arResult["arUser"]["WORK_DEPARTMENT"]?>" />
                        </div>

                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?=GetMessage('USER_POSITION')?></label>
                            <input type="text" name="WORK_POSITION" maxlength="255" value="<?=$arResult["arUser"]["WORK_POSITION"]?>" />
                        </div>
                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?=GetMessage('USER_COUNTRY')?></label>
                            <?=$arResult["COUNTRY_SELECT_WORK"]?>
                        </div>
                        <div class="form_fieldset">
                            <label for="" class="formlabel ">Регион:</label>
                            <?echo Cinvestments::getRegionSelect($arResult["arUser"]["WORK_STATE"],"WORK_STATE");?>
                            <?/*<input type="text" name="WORK_STATE" maxlength="255" value="<?=$arResult["arUser"]["WORK_STATE"]?>" /> */?>
                        </div>

                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?=GetMessage('USER_CITY')?></label>
                            <input type="text" name="WORK_CITY" maxlength="255" value="<?=$arResult["arUser"]["WORK_CITY"]?>" />
                        </div>

                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?=GetMessage("USER_STREET")?></label>
                            <textarea cols="30" rows="5" name="WORK_STREET"><?=$arResult["arUser"]["WORK_STREET"]?></textarea>
                        </div>

                        <div class="form_fieldset">
                            <label for="" class="formlabel ">E-Mail:</label>
                            <input type="text" name="WORK_MAILBOX" maxlength="255" value="<?=$arResult["arUser"]["WORK_MAILBOX"]?>" />
                        </div>
                    </div>
                </li>
                <li class="switcher_container">
                    <div class="flex_full">
                        <div class="form_fieldset">
                            <label for="" class="formlabel "><?= GetMessage('LOGIN') ?></label>
                            <input type="text" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"] ?>"/>
                        </div>
                        <? if ($arResult["PHONE_REGISTRATION"]): ?>
                            <div class="form_fieldset">
                                <label for="" class="formlabel "><? echo GetMessage("main_profile_phone_number") ?></label>
                                <input type="text" class="phonefield" name="PHONE_NUMBER" maxlength="50" value="<? echo $arResult["arUser"]["PHONE_NUMBER"] ?>"/>
                            </div>

                        <? endif ?>
                        <? if ($arResult['CAN_EDIT_PASSWORD']): ?>
                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?= GetMessage('NEW_PASSWORD_REQ') ?></label>
                                <input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="new-password"
                                       class="bx-auth-input"/>
                            </div>
                            <div class="form_fieldset">
                                <label for="" class="formlabel "><?= GetMessage('NEW_PASSWORD_CONFIRM') ?></label>
                                <input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value=""
                                       autocomplete="new-password"/>
                            </div>

                            <? if ($arResult["SECURE_AUTH"]): ?>
                                <div class="form_fieldset">
                                        <span class="bx-auth-secure" id="bx_auth_secure"
                                              title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
                                                <div class="bx-auth-secure-icon"></div>
                                        </span>
                                        <noscript>
                                            <span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
                                              <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                            </span>
                                        </noscript>
                                        <script type="text/javascript">
                                            document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                        </script>
                                </div>
                            <? endif ?>
                        <? endif ?>
                        <p><? echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></p>

                    </div>
                </li>
            </ul>
            <p><input type="submit"  class="formsubmit btn " name="save"
                      value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
        </form>


    <? endif ?>

</div>



