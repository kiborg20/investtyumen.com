<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$data = [
    "CATEGORY_ID"=>0,
    "TITLE"=>"Запись на мероприятие - ".$_POST['EVENT_NAME']." от ".date("d.m.Y H:i:s"),
    "ASSIGNED_BY_ID"=>ASSIGNED_BY_ID,
];

$users = [];

foreach($_POST["USERNAME"] as $key=>$dataa){
    $user = [];
    $user["NAME"] = $dataa;
    $user["PHONE"] = $_POST["USERPHONE"][$key];
    $user["EMAIL"] = $_POST["USEREMAIL"][$key];

    $users[] = $user;
}

$userIDs = [];

foreach($users as $user){
    $userID = Cinvestments::findContactByPhoneNumber($user["PHONE"]);
    if($userID!=false){
        $userIDs[] = $userID;
    }else{
        $data_con = [
            "NAME"=>$user["NAME"],
            "ASSIGNED_BY_ID"=> ASSIGNED_BY_ID,
            "PHONE"=> [
                [ "VALUE"=> $user["PHONE"], "VALUE_TYPE"=> "WORK" ],
            ],
            'EMAIL'=>[
                [ "VALUE"=> $user["EMAIL"], "VALUE_TYPE"=> "WORK" ],
            ],
        ];

        $addcontact = Cinvestments::contactADD($data_con);

        $userIDs[] = $addcontact["result"];
    }
}

$data["CONTACT_IDS"] = $userIDs;

if(isset( $_POST['EVENT_NAME'])){
    $data['UF_CRM_1678286693349'] =  $_POST['EVENT_NAME'];
}

if(isset($_POST['EVENT_THEME'])){
    $data['UF_CRM_1678286729972'] = $_POST['EVENT_THEME'];
}

if(isset($_POST['EVENT_DATE'])){
    $data['UF_CRM_1678286761593'] = $_POST['EVENT_DATE']." ".$_POST['EVENT_TIME'];
}

if(isset($_POST['EVENT_PLACE'])){
    $data['UF_CRM_1678286820968'] = $_POST['EVENT_PLACE'];
}

if(isset($_POST['INITIATOR_INN']) && $_POST['INITIATOR_INN']!=""){
    $company = Cinvestments::findCompanyByINN($_POST['INITIATOR_INN']);
}else{
    if(isset($_POST['INITIATOR']) && $_POST['INITIATOR']!=""){
        $company = Cinvestments::findCompanyByName($_POST['INITIATOR']);
    }else{
        $company = false;
    }
}

if($company!=false){
    $data["COMPANY_ID"] = $company;
}else{
    $data_com = [
        "TITLE"=>$_POST['INITIATOR'],
        "ASSIGNED_BY_ID"=> ASSIGNED_BY_ID,
        "UF_CRM_1675709492967"=>$_POST['INITIATOR_INN']
    ];
    $addcompany = Cinvestments::companyADD($data_com);
    $data["COMPANY_ID"] = $addcompany["result"];
}

$res = Cinvestments::leadADD($data);

if ($res["result"]>0)
    //echo "New ID: ".$PRODUCT_ID;
    echo '<h2 class="formresult_header">Спасибо <br>ваша заявка № ' . date('mdY') . '_' . $res["result"] . ' принята.</h2><p class="formresult_text">Мы свяжемся с Вами в ближайшее время.</p>';
else
    //echo "Error: ".$el->LAST_ERROR;
    echo '<h2 class="formresult_header">Ошибка отправки заявки.</h2><p class="formresult_text">' . $el->LAST_ERROR . '</p>';

?>