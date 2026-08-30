<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
//mpr($arParams , false);
$depthLvl = $arParams['TOP_DEPTH'];
$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y' , 'SECTION_ID' => $arParams['SECTION_ID']);
$arSelect = array('ID', 'NAME');

$arjSectionList = array();
$objSectionList = CIBlockSection::GetList(
    array(
        'left_margin'=> 'asc'
    ),
    $arFilter,
    false
);
$arResult['SECTION_TREED'] = getTreedSection($objSectionList, $arFilter, $arParams);
function getTreedSection ($objSectionList , $arFilter , $arParams) {
    $arResult = array();
    $arSection = array();
    while ($elSection = $objSectionList->Fetch()) {
        $elSection['SUB_SECTION'] = repeatSection($elSection , $arFilter ,$arParams);
        $arSection[] = $elSection;
    }

    return $arSection;
}
function repeatSection ($parentSection , $arFilter , $arParams) {
    $arFilter['SECTION_ID'] = $parentSection['ID'];
    $arSubSection = array();
    $subObj = CIBlockSection::GetList(
        array(
            'left_margin'=> 'asc'
        ),
        $arFilter
    );
    while ($elSubSection = $subObj->Fetch()) {
        if (!empty($elSubSection)) {

            $elSubSection['ITEMS'] = getTreedSectionEl($elSubSection , $arParams);
            $elSubSection['SUB_SECTION'] = repeatSection($elSubSection , $arFilter , $arParams);

            $arSubSection[] = $elSubSection;
        }
    }
    return $arSubSection;
}
function getTreedSectionEl ($arSection , $arParams) {
    $arResult = array();
    $objEl = CIBlockElement::GetList(
        array(
            'sort' => 'acs'
        ),
        array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'SECTION_ID' => $arSection['ID']
        ),
        false,
        false,
        array(
            'NAME',
            'DETAIL_TEXT',
            'DETAIL_TEXT_TYPE',
            'PROPERTY_NAME'
        )
    );
    while($elElement = $objEl->Fetch()) {
        $arResult[] = $elElement;
    }
    return $arResult;
}
//mpr($arjSectionList , false);

?>