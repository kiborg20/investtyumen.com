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
        <? foreach ($arResult['PROPS'] as $propItem): ?>
            <th><?=$propItem?></th>
        <? endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <tr>
            <? foreach ($arResult['PROPS'] as $key=> $propItem):?>
                    <td>
                        <?
                        switch ($key){
                            case "PROJECT_NAME":
                                echo "<a href='".$arItem["DETAIL_PAGE_URL"]."'>".$arItem['PROPERTIES'][$key]['VALUE']."</a>";
                                break;
                            default:
                                if(is_array($arItem['PROPERTIES'][$key]['VALUE'])){
                                    foreach($arItem['PROPERTIES'][$key]['VALUE'] as $item){
                                        echo $item.", ";
                                    }
                                }else{
                                    echo $arItem['PROPERTIES'][$key]['VALUE'];
                                }

                            break;
                        }
                        ?>
                    </td>
            <? endforeach; ?>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>



