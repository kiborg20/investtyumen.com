<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
 
$SITE_ID = 's1';                       
 
$EVENT_TYPE = 'FEEDBACK_FORM3';
 
//убираем первый слешь в урле- вам не обязательная часть :)
// $url='';
// if(isset($_POST['url'] )&& !empty($_POST['url'])){
// $url=$_POST['url'];
// if($url[0]=='/'){
// $url= substr( $url, 1);
// }
// }
 
$arMailFields = array(
'AUTHOR' => $_POST['name'],
'PHONE' => $_POST['phone'],
'AUTHOR_EMAIL' => $_POST['email'],
'TEXT' => $_POST['message'],
'THEME' => $_POST['theme'],
'URL' => ''//$url, //сюда добавил урл
);
if ($_POST['company']) {
    $arMailFields['COMPANY'] = $_POST['company'];
}

$mess="Спасибо! <br>Мы свяжемся с Вами в ближайшее время";
 
$arMailFields_clear=array();

foreach($arMailFields as $key => $value){
    $arMailFields_clear[$key] = htmlspecialchars($value);
}
 
//собираем файлы из загрузки в массив .
$files=array();
foreach ($_FILES as $file){
if (!empty($file['tmp_name'])) {
$files[]=CFile::SaveFile($file,'form');
}
}
 
CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields_clear, 'Y','',$files);


$comments = '<hr>Заполнена форма: Заявка на сопровождение<hr>';
$comments .= 'Тема заявки: ' . $arMailFields_clear['THEME'] . '<hr>';
$comments .= 'Сообщение заявителя: ' . $arMailFields_clear['TEXT'] . '<hr>';

$data = [
    'fields' => [
        'TITLE' => 'Сайт: investintyumen.ru Форма: Заявка на сопровождение от ' . date("d.m.y - H:i"),
        'COMPANY_TITLE' => $arMailFields_clear['COMPANY'],
        'NAME' => $arMailFields_clear['AUTHOR'],
        'PHONE' => [['VALUE' => $arMailFields_clear['PHONE'], 'VALUE_TYPE' => 'WORK']],
//        'PHONE' => [['VALUE' => getPhone($phone), 'VALUE_TYPE' => 'WORK']],
        'EMAIL' => [['VALUE' => $arMailFields_clear['AUTHOR_EMAIL'], 'VALUE_TYPE' => 'WORK']],

        'UF_CRM_1665344803590' => [
            'fileData' => [
                $_FILES['file']['name'],
                base64_encode(file_get_contents($_FILES['file']['tmp_name']))
            ]
        ],


//        'UF_CRM_1665071874500' => [
//            ['fileData' => ['test2.txt', '2222222']],
//            ['fileData' => ['test3.txt', '3333333']],
//        ],
//            'STAGE_ID' => 'NEW',
        'SOURCE_ID' => 'WEB',
        'COMMENTS' => $comments,
//        'OPPORTUNITY' => $_POST['payment']['amount'],
        'ASSIGNED_BY_ID' => '1',
//        'TRACE' => getTrace($_POST['COOKIES']),

//    ], 'params' => [
//        'REGISTER_SONET_EVENT' => 'Y'
//    ]
    ]
];
sendDataToBitrix('crm.lead.add', $data);




echo $mess;