<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
//CJSCore::init(['jquery2']);
$this->addExternalCss("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css");
$this->addExternalJS("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js");

$this->addExternalCss(SITE_TEMPLATE_PATH . "/js/select2/dist/css/select2.min.css");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/select2/dist/js/select2.full.js");

//$this->addExternalCss("https://cdn.jsdelivr.net/npm/jquery-form-styler@2.0.2/dist/jquery.formstyler.min.css");
//$this->addExternalJS("https://cdn.jsdelivr.net/npm/jquery-form-styler@2.0.2/dist/jquery.formstyler.min.js");
?>

<div class="formtext"><?= $arResult['DESCRIPTION'] ?></div>
<?
$js_data = [
    "iblock_id" => $arParams["IBLOCK_ID"],
    'ajaxpath' => $componentPath . '/ajax.php',
    'mask' => '+7(999)999-99-99'
];
?>
<script>
    var fparams = <?=CUtil::PhpToJSObject($js_data)?>;
</script>


<form action="#" class="infoblock_form" id="infoblock_form" enctype="multipart/form-data">
    <? foreach ($arResult["PROPERTIES"] as $property):
        if ($property["HINT"] != "HIDE") {
            switch ($property["PROPERTY_TYPE"]) {
                case "S":
                    if ($property["USER_TYPE"] == 'Date') {
                        ?>
                        <div class="form_fieldset <? if ($property["MULTIPLE"] == "Y") echo 'multiple_field'; ?>">
                            <label for="<?= $property["CODE"]; ?>"
                                   class="formlabel <? if ($property["IS_REQUIRED"] == "Y") echo 'required_field'; ?>"><?= $property["NAME"]; ?></label>
                            <div class="<? if ($property["MULTIPLE"] == "Y") echo 'multiple_field'; ?>">
                                <input type="date"
                                       name='<?= $property["CODE"]; ?><? if ($property["MULTIPLE"] == "Y") echo '[]'; ?>' <? if ($property["IS_REQUIRED"] == "Y") echo 'required'; ?>
                                ">
                            </div>
                            <? if ($property["MULTIPLE"] == "Y") echo '<a  href="#" class="add_field formlabel">Добавить</a>'; ?>
                        </div>
                        <?
                    } else {
                        if($property["USER_TYPE"]=="HTML"){?>
                            <div class="form_fieldset">
                                <label for="<?= $property["CODE"]; ?>"
                                       class="formlabel  <? if ($property["IS_REQUIRED"] == "Y") echo 'required_field'; ?>"><?= $property["NAME"]; ?></label>
                                <textarea name="<?= $property["CODE"]; ?>" id="" cols="30" rows="60" <? if ($property["IS_REQUIRED"] == "Y") echo 'required'; ?>></textarea>

                            </div>
                        <?}else{

                        ?>
                        <div class="form_fieldset">
                            <label for="<?= $property["CODE"]; ?>"
                                   class="formlabel <? if ($property["CODE"] == "EMAIL") echo "emaillabel"; ?> <? if ($property["IS_REQUIRED"] == "Y") echo 'required_field'; ?>"><?= $property["NAME"]; ?></label>
                            <input type='text'
                                   class="<? if ($property["CODE"] == "EMAIL") echo "emailfield"; ?><? if ($property["CODE"] == "PHONE") echo "phonefield"; ?><? if ($property["CODE"] == "SITY") echo "dadataField"; ?>"
                                   name='<?= $property["CODE"]; ?>' <? if ($property["IS_REQUIRED"] == "Y") echo 'required'; ?>
                                   value="<?= Cinvestments::getCurfieldValue($property); ?>"
                            >
                        </div>
                        <?}
                    } ?>

                    <? break;
                case "L":
                    ?>
                    <div class="form_fieldset <? if ($property["MULTIPLE"] == "Y"){echo "multipleSelectBox";}?>">
                        <label for="<?= $property["CODE"]; ?>"
                               class="formlabel <? if ($property["IS_REQUIRED"] == "Y") echo 'required_field'; ?>"><?= $property["NAME"]; ?></label>
                        <? if ($property["MULTIPLE"] == "Y"){?>
                            <div class="checkselect">
                                <? $property_enums = CIBlockPropertyEnum::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $arResult['IBLOCK_ID'], "CODE" => $property["CODE"]));
                                ?>
                                <? while ($enum_fields = $property_enums->GetNext()) { ?>

                                    <label><input type="checkbox" name="<?= $property["CODE"]."[]"; ?>" value="<?= $enum_fields['ID'] ?>" ><?= $enum_fields["VALUE"] ?></label>
                                <?}?>

                            </div>

                        <?}else{?>
                            <select class="select2_field"
                                    name="<?= $property["CODE"]; ?>" <? if ($property["IS_REQUIRED"] == "Y") echo 'required'; ?> >
                                <? $property_enums = CIBlockPropertyEnum::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $arResult['IBLOCK_ID'], "CODE" => $property["CODE"]));
                                ?>
                                <option value=""></option>
                                <? while ($enum_fields = $property_enums->GetNext()) { ?>
                                    <option value="<?= $enum_fields['ID'] ?>"><?= $enum_fields["VALUE"] ?></option>
                                    <?
                                } ?>
                            </select>
                        <?}?>

                    </div>
                    <? break;
                case "F":
                    ?>
                    <div class="form_fieldset">
                        <label for="<?= $property["CODE"]; ?>"
                               class="formlabel <? if ($property["IS_REQUIRED"] == "Y") echo 'required_field'; ?>"><?= $property["NAME"]; ?></label>
                        <div class="input__wrapper">

                            <input type='file' id="input__file_<?= $property["ID"]; ?>" class="input inputfile formfile"
                                   name='<?= $property["CODE"]; ?>[]' <? if ($property["IS_REQUIRED"] == "Y") echo 'required'; ?> <? if ($property["MULTIPLE"] == "Y") echo 'multiple'; ?>
                            ">

                            <label for="input__file_<?= $property["ID"]; ?>" class="input__file-button">
                                <span class="input__file-button-text">Выберите файл</span>

                                <span class="input__file-icon-wrapper"><img class="input__file-icon"
                                                                            src="<?= SITE_TEMPLATE_PATH ?>/img/add.svg"
                                                                            alt="Выбрать файл" width="25"></span>

                            </label>
                        </div>
                    </div>
                    <? break;
                case "N":
                    ?>
                    <div class="form_fieldset">
                        <label for="<?= $property["CODE"]; ?>"
                               class="formlabel <? if ($property["IS_REQUIRED"] == "Y") echo 'required_field'; ?>"><?= $property["NAME"]; ?></label>
                        <input type='number'
                               name='<?= $property["CODE"]; ?>' <? if ($property["IS_REQUIRED"] == "Y") echo 'required'; ?>
                               min="1" step="1" value="">
                    </div>
                    <? break;
            }
        } else {
            if($property["CODE"]=="PLASE"){?>
                <input type="hidden" id="place" name='<?= $property["CODE"]; ?>'>
            <?}?>


        <? }
     ?>

    <? endforeach; ?>
    <input type="hidden" name="iblockID" value="<?= $arParams["IBLOCK_ID"] ?>">

    <?$statuses = Cinvestments::StatusInfo($arParams["IBLOCK_ID"])?>
    <input type="hidden" name="STATUS" value="<?=$statuses["RASSMOTR"]?>">

    <div class="form_fieldset">
        <input type="submit" class="formsubmit btn " value="Отправить">
    </div>

    <?if($arResult["FILES"]!=""):?>
        <div class="form_fieldset">
           <h2 class="docsheader">Скачайте шаблоны документов</h2>
            <?=$arResult["FILES"]?>
        </div>

    <?endif;?>

</form>
