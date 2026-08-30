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

<table class="profile_table" id="zaim_table_<?=$arParams['IBLOCK_ID'].$arParams['TABLE_ID_PREFFIX'] ?>">
    <thead>
    <tr>
        <? foreach ($arResult['PROPS'] as $propItem):?>
            <th><?=$propItem?></th>
        <? endforeach; ?>
        <th>Подать заявку</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <tr>
            <? foreach ($arItem["DISPLAY_PROPERTIES"] as $propItem): ?>
                <td>
                    <?
                    switch ($propItem['CODE']){
                    case "PLACE_NAME":
                        echo "<a class='plaсe_name' href='".$arItem["DETAIL_PAGE_URL"]."'>".$propItem['VALUE']."</a>";
                        break;
                    default:
                        echo $propItem['VALUE'];
                        break;

                    }
                   ?>
                </td>
            <? endforeach; ?>
            <td>
                <a href="#" class="plase_reserved" data-place="<?=$arItem["ID"]?>">Подать заявку</a>
            </td>
        </tr>
    <? endforeach; ?>

    </tbody>
</table>



