<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if($_REQUEST["auth"]["application_token"]=="q7cdb6vvcb0btasczx148xu7qln10pil" ){
    if($_REQUEST["event"] == "ONCRMDEALUPDATE"){

        $dealID = $_REQUEST["data"]["FIELDS"]["ID"];
        $res = Cinvestments::sendDataToBitrix("crm.deal.get", ["id"=>$dealID]);
        $iblockid = $res["result"]["UF_CRM_1670235377704"];
        $elementId =  $res["result"]["UF_CRM_1670235285095"];

        //если есть привязка к элементу и инфоблоку
        if(isset($iblockid) && $iblockid!="" && isset($elementId) && $elementId!=""){
            //если сделка успешна
            if($res["result"]["STAGE_ID"] == "WON"){
                Cinvestments::setElementStatus($iblockid, $elementId, "ODOBR");
            }
            if($res["result"]["STAGE_ID"] == "LOSE"){
                Cinvestments::setElementStatus($iblockid, $elementId, "OTKLON");
            }
        }
    }
}
?>