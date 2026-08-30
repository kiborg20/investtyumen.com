<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("iblock")) return;
global $USER;
$template = '';
if (!$USER->IsAuthorized()) {
    $template = 'none';
} else {
    $arUser = CUser::GetByID($USER->GetID())->Fetch();
    $arResult['NAME'] = $arUser['LAST_NAME'] . ' '  . $arUser['NAME']. ' ' . $arUser['SECOND_NAME'];
    $imgUser = false;
    if (!empty($arUser['PERSONAL_PHOTO'])) {
        $imgUser = CFile::GetPath($arUser['PERSONAL_PHOTO']);
    }
    $arResult['PHOTO'] = $imgUser;
}
$this->IncludeComponentTemplate($template);

