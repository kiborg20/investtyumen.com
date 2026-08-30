<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("iblock")) return;

$arResult = CUser::GetList(
    ($by="id"),
    ($order="desc"),
    array(
        'ID' => $arParams['USER_ID']
    )
)->Fetch();

$this->IncludeComponentTemplate();

