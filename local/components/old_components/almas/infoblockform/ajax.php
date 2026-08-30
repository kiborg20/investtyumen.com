<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$iblockID = is_numeric($_POST['iblockID']) ? (int)$_POST["iblockID"] : die("ID инфоблока указан неверно");

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

if (CModule::IncludeModule("iblock")) {
    $el = new CIBlockElement;

    $PROPS = array();
    foreach ($_POST as $key => $prop) {
        if (is_array($prop)) {
            $temp = [];
            foreach ($prop as $pkey => $item) {
                if (validateDate($item, 'Y-m-d')) {
                    $temp[$pkey] = date('d.m.Y H:i:s', strtotime($item));
                }else{
                    $temp[$pkey] = $item;
                }
            }

            $PROPS[$key] = $temp;
            unset($temp);
        } else {
            if (validateDate($prop, 'Y-m-d')) {
                $PROPS[$key] = date('d.m.Y H:i:s', strtotime($prop));
            } else {

                if($key=="USLOVIYA_INVESTIROVANIYA" || $key=="TEXT" || $key=="OTVET"){
                    $PROPS[$key] = array(
                        "VALUE" => array(
                            "TEXT" => $prop,
                            "TYPE" => "html"
                        ));
                }else{
                    $PROPS[$key] = $prop;
                }
            }
        }
    }
    global $USER;
    $PROPS["USER"] = $USER->GetID();

    if (isset($_FILES) && count($_FILES) != 0) {
        foreach ($_FILES as $key_file_field => $filefield) {
            $files = Cinvestments::reArrayImages($filefield);
            $PROPS[$key_file_field] = $files;
        }
    }


    $elname = "Заполнение заявки " . date("d.m.Y H:i:s");



    $arLoadProductArray = array(
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID" => $iblockID,
        "PROPERTY_VALUES" => $PROPS,
        "NAME" => $elname,
        "ACTIVE" => "Y",
    );

    if ($PRODUCT_ID = $el->Add($arLoadProductArray))
        //echo "New ID: ".$PRODUCT_ID;
        echo '<h2 class="formresult_header">Спасибо <br>ваша заявка № ' . date('mdY') . '_' . $PRODUCT_ID . ' принята.</h2><p class="formresult_text">Мы свяжемся с Вами в ближайшее время.</p>';
    else
        //echo "Error: ".$el->LAST_ERROR;
        echo '<h2 class="formresult_header">Ошибка отправки заявки.</h2><p class="formresult_text">' . $el->LAST_ERROR . '</p>';


}



?>