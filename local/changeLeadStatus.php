<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule("iblock");

if($_REQUEST["auth"]["application_token"]=="eybv3aaaj977h7r56qvo827q1gwg4p54" ){
    if($_REQUEST["event"] == "ONCRMLEADUPDATE"){


        $dealID = $_REQUEST["data"]["FIELDS"]["ID"];
        $res = Cinvestments::sendDataToBitrix("crm.lead.get", ["id"=>$dealID]);

        $elementId = $res["result"]["UF_CRM_1678386166"];
        $iblockid = $res["result"]["UF_CRM_1678386142"];
        $otvet = $res["result"]["UF_CRM_1678386106"];

        //если есть привязка к элементу и инфоблоку
        if(isset($iblockid) && $iblockid!="" && isset($elementId) && $elementId!=""){
            if($res["result"]["UF_CRM_1678386106"]!=""){
                $db_props = CIBlockElement::GetProperty($iblockid, $elementId, array("sort" => "asc"), Array("CODE"=>"OTVET"));
                if($ar_props = $db_props->Fetch()) {
                    $prop = $ar_props["VALUE"];
                }else {
                    $prop = false;
                }

                if($prop === false){
                    CIBlockElement::SetPropertyValues($elementId, $iblockid, $otvet, "OTVET");
                }
            }
        }
    }
}
?>