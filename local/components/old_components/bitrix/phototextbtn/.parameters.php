<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$ext = 'wmv,wma,flv,vp6,mp3,mp4,aac,jpg,jpeg,gif,png';
$arComponentParameters = array(
    "PARAMETERS" => array(
        "TYPEPHOTO" => array(
            "PARENT" => "BASE",
            "NAME" => "Компоновка фото",
            "TYPE" => "LIST",
            "VALUES"    =>  array(
                "1F2" =>  "1 + 2 фото",
                "2F1" =>  "2 + 1 фото",
            ),
            "MULTIPLE"  =>  "N",
            "DEFAULT" => "Файл",
            "REFRESH" => "Y",
        ),
        "PIC1" => array(
            "PARENT" => "BASE",
            "NAME" => "Фото 1",
            "TYPE" => "FILE",
            "FD_TARGET" => "F",
            "FD_UPLOAD" => true,
            "FD_USE_MEDIALIB" => false,
            "FD_MEDIALIB_TYPES" => Array('video', 'sound'),
        ),
        "PIC2" => array(
            "PARENT" => "BASE",
            "NAME" => "Фото 2",
            "TYPE" => "FILE",
            "FD_TARGET" => "F",
            "FD_UPLOAD" => true,
            "FD_USE_MEDIALIB" => false,
            "FD_MEDIALIB_TYPES" => Array('video', 'sound'),
        ),
        "PIC3" => array(
            "PARENT" => "BASE",
            "NAME" => "Фото 3",
            "TYPE" => "FILE",
            "FD_TARGET" => "F",
            "FD_UPLOAD" => true,
            "FD_USE_MEDIALIB" => false,
            "FD_MEDIALIB_TYPES" => Array('video', 'sound'),
        ),
        "TITLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Заголовок",
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ),
        "TEXT" => array(
            "PARENT" => "BASE",
            "NAME" => "Текст блока",
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ),
        "LINKTITLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Текст кнопки",
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ),
        "LINKTYPE" => array(
            "PARENT" => "BASE",
            "NAME" => "Тип ссылки",
            "TYPE" => "LIST",
            "VALUES"    =>  array(
                "LTF" =>  "Файл",
                "LTL" =>  "Ссылка",
            ),
            "MULTIPLE"  =>  "N",
            "DEFAULT" => "Файл",
            "REFRESH" => "Y",
        ),
    ),
);
if ($arCurrentValues["LINKTYPE"] == "LTL"){
    $arComponentParameters["PARAMETERS"]["LINK"] = array(
        "PARENT" => "BASE",
        "NAME" => "Ссылка",
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "REFRESH" => "N"
    );
}
else
{
    $arComponentParameters["PARAMETERS"]["LINK"] = array(
        "PARENT" => "BASE",
        "NAME" => "Файл",
        "TYPE" => "FILE",
        "FD_TARGET" => "F",
        "FD_UPLOAD" => true,
        "FD_USE_MEDIALIB" => false,
        "FD_MEDIALIB_TYPES" => Array('video', 'sound'),
    );
};