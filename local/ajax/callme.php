<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$iblockID = 47;

if(CModule::IncludeModule("iblock"))
{
    $el = new CIBlockElement;

    $PROPS = array(
        'NAME'=>$_POST["name"],
        'PHONE'=>$_POST["phone"],

    );

    $elname = "запрос обратного звонка от ".date("d.m.Y H:i:s");

    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID"      => $iblockID,
        "PROPERTY_VALUES"=> $PROPS,
        "NAME"           => $elname,
        "ACTIVE"         => "Y",
    );

    $data = [
        "TITLE" => "Заявка на обратный звонок по телефону - ".$_POST["phone"],
        "NAME"=>$_POST["name"],
        "PHONE"=> [
            [ "VALUE"=> $_POST["phone"], "VALUE_TYPE"=> "WORK" ],
        ],
    ];

     $res = Cinvestments::leadADD($data);


    if($PRODUCT_ID = $el->Add($arLoadProductArray))
        echo $_POST["phone"];



}











?>