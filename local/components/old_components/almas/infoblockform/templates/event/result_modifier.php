<?

// выбираем привязки к шаблонам документов
$arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = array("IBLOCK_ID" => 49, "NAME" => $arResult["CODE"], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
$el=[];
while ($ob = $res->GetNextElement()) {
    $el = $ob->GetFields();
    $arProps = $ob->GetProperties();
    $el['PROPS'] = $arProps;
}
$files = "";
if(isset($el["PROPS"]["FILES"]['VALUE'])&&$el["PROPS"]["FILES"]['VALUE']!=""){
    foreach($el["PROPS"]["FILES"]['VALUE'] as $key=>$fileId){
        $file=CFile::GetByID($fileId);
        $arFile = $file->Fetch();
        $files = $files."<a href='".CFile::GetPath($fileId)."'>".$arFile["ORIGINAL_NAME"]."</a>";

        if($key!=count($el["PROPS"]["FILES"]['VALUE'])-1){
            $files = $files."<br>";
        }
    }
}
$arResult["FILES"] = $files;
?>

