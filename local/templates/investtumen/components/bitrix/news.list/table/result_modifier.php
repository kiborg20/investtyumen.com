<?foreach($arResult["ITEMS"] as $key => $item){
    $temp = $item['DISPLAY_PROPERTIES'];

    usort($temp, function($a,$b){
        if ($a["SORT"] == $b["SORT"]) {
            return 0;
        }
        return ($a["SORT"] < $b["SORT"]) ? -1 : 1;
    });

    $arResult["ITEMS"][$key]['DISPLAY_PROPERTIES'] = $temp;


}

$tableprops = array();

foreach($arResult["ITEMS"] as $key => $item){
    foreach($item['DISPLAY_PROPERTIES'] as $prop){
        if(!in_array($prop["CODE"],$tableprops)){
            $tableprops[$prop["CODE"]] = $prop["NAME"];
        }
    }
}

$arResult['PROPS'] = $tableprops;






?>