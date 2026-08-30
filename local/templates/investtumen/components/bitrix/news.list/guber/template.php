<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$js_data = [
"table_id"=>"#zaim_table_".$arParams['IBLOCK_ID'].$arParams['TABLE_ID_PREFFIX'],
];

?>
<script>
    var params = <?=CUtil::PhpToJSObject($js_data)?>;
</script>
<?if(count($arResult["ITEMS"])>0):?>
<table class="profile_table" id="zaim_table_<?=$arParams['IBLOCK_ID'].$arParams['TABLE_ID_PREFFIX'] ?>">

    <thead>
    <tr>
        <td>Дата обращения</td>
        <td>Ф.И.О</td>
        <td>Компания</td>
        <td>Текст обращения</td>
        <td>Ответ на обращение</td>
    </tr>
    </thead>

    <tbody>
    <? foreach ($arResult["ITEMS"] as $arItem):?>
        <tr>
             <td style="width:120px"><?=date('d.m.Y', strtoTime($arItem["DATE_CREATE"]))?></td>
             <td style="width:150px"><?=$arItem["PROPERTIES"]["CONTACTS"]["VALUE"];?></td>
             <td style="width:150px"><?=$arItem["PROPERTIES"]["INITIATOR"]["VALUE"];?></td>
             <td style="width:300px"><?=$arItem["PROPERTIES"]["TEXT"]["VALUE"]["TEXT"];?></td>
             <td style="width:300px"><?=$arItem["PROPERTIES"]["OTVET"]["VALUE"]["TEXT"];?></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
<?endif;?>


