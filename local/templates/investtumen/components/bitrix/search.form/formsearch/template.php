<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<div class="bgblue">
<div class="footersearch">
<form action="<?=$arResult["FORM_ACTION"]?>">
                 
	<input type="text" class="inputwhite search" name="q" placeholder="Поиск по сайту" value="" size="15" maxlength="50" pattern="[0-9A-Яа-яA-Za-z]"/>
	<input  class="searchbtn" name="s" type="submit" />
</form>
</div></div>