<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//CJSCore::init(['jquery2']);
$this->addExternalCss("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css");
$this->addExternalJS("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js");

$this->addExternalCss(SITE_TEMPLATE_PATH."/js/select2/dist/css/select2.min.css");
//$this->addExternalJS(SITE_TEMPLATE_PATH."/js/select2/dist/js/select2.full.js");

?>
<h1 class="formtitle"><?=$arResult['TITLE']?></h1>
<div class="formtext"><?=$arResult['DESCRIPTION']?></div>
<?


$js_data = [
        "iblock_id"=>$arResult["IBLOCK_ID"],
        'ajaxpath'=>$componentPath.'/ajax.php',
        'mask'=>'+7(999)999-99-99'
];

?>
<script>
    var params = <?=CUtil::PhpToJSObject($js_data)?>;
</script>


<form action="#" class="infoblock_form" id="infoblock_form" enctype="multipart/form-data">
    <?foreach($arResult["PROPERTIES"] as $property):?>
        <?switch ($property["PROPERTY_TYPE"]) {
            case "S":?>
            <?if($property["USER_TYPE"]=='Date'){?>
                <div class="form_fieldset <?if($property["MULTIPLE"]=="Y") echo 'multiple_field';?>">
                    <label for="<?=$property["CODE"];?>" class="formlabel <?if($property["IS_REQUIRED"]=="Y") echo 'required_field';?>"><?=$property["NAME"];?></label>
                    <div class="<?if($property["MULTIPLE"]=="Y") echo 'multiple_field';?>">
                        <input type="date" name ='<?=$property["CODE"];?><?if($property["MULTIPLE"]=="Y") echo '[]';?>' <?if($property["IS_REQUIRED"]=="Y") echo 'required';?> ">
                    </div>
                    <?if($property["MULTIPLE"]=="Y") echo '<a  href="#" class="add_field formlabel">Добавить</a>';?>
                </div>
            <?}else{?>
                <div class="form_fieldset">
                    <label for="<?=$property["CODE"];?>" class="formlabel <?if($property["CODE"]=="EMAIL")echo"emaillabel";?> <?if($property["IS_REQUIRED"]=="Y") echo 'required_field';?>"><?=$property["NAME"];?></label>
                    <input type='text' class="<?if($property["CODE"]=="EMAIL")echo"emailfield";?><?if($property["CODE"]=="PHONE")echo"phonefield";?><?if($property["CODE"]=="SITY")echo"dadataField";?>" name ='<?=$property["CODE"];?>' <?if($property["IS_REQUIRED"]=="Y") echo 'required';?> >
                </div>
            <?}?>

            <?break;
            case "L":?>
                <div class="form_fieldset">
                    <label for="<?=$property["CODE"];?>" class="formlabel <?if($property["IS_REQUIRED"]=="Y") echo 'required_field';?>"><?=$property["NAME"];?></label>

                    <select class="select2_field" name="<?=$property["CODE"];?><?if($property["MULTIPLE"]=="Y") echo '[]';?>" <?if($property["IS_REQUIRED"]=="Y") echo 'required';?> <?if($property["MULTIPLE"]=="Y") echo 'multiple';?> >
                        <?$property_enums = CIBlockPropertyEnum::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $arResult['IBLOCK_ID'], "CODE" => $property["CODE"]));
                        ?>
                        <option value=""></option>
                        <?while ($enum_fields = $property_enums->GetNext()) {?>
                            <option value="<?=$enum_fields['ID']?>"><?=$enum_fields["VALUE"]?></option>
                        <?}?>
                    </select>
                </div>
            <?break;
            case "F":?>
                <div class="form_fieldset">
                    <label for="<?=$property["CODE"];?>" class="formlabel <?if($property["IS_REQUIRED"]=="Y") echo 'required_field';?>"><?=$property["NAME"];?></label>
                    <input type='file' name ='<?=$property["CODE"];?>' <?if($property["IS_REQUIRED"]=="Y") echo 'required';?> <?if($property["MULTIPLE"]=="Y") echo 'multiple';?> ">
                </div>
            <?break;
            case "N":?>
                <div class="form_fieldset">
                    <label for="<?=$property["CODE"];?>" class="formlabel <?if($property["IS_REQUIRED"]=="Y") echo 'required_field';?>"><?=$property["NAME"];?></label>
                    <input type='number' name ='<?=$property["CODE"];?>' <?if($property["IS_REQUIRED"]=="Y") echo 'required';?> min="1" step="1" value="">
                </div>
                <?break;
        }
        ?>

    <?endforeach;?>
    <input type="hidden" name="iblockID" value="<?=$arResult["IBLOCK_ID"]?>">
    <div class="form_fieldset">
        <input type="submit" class="formsubmit " value="Отправить" >
    </div>

</form>
