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







?>