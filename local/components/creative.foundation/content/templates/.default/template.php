<?php

	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

?>
<div class="content" data-id="<?=$arResult['current']['iblock']?>">
	<?php if ($arResult['current']['type'] === 'section'): ?>
		<div class="content_list">
			<?php $APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"",
				Array(
					"IBLOCK_ID" => $arResult['current']['iblock'],
					"NEWS_COUNT" => 20,
					"SORT_BY1" => 'SORT',
					"SORT_ORDER1" => 'ASC',
					"SORT_BY2" => 'ID',
					"SORT_ORDER2" => 'DESC',
					"FIELD_CODE" => [],
					"PROPERTY_CODE" => [],
					"SET_TITLE" => 'N',
					"INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
					"CACHE_TYPE" => 'A',
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"DISPLAY_TOP_PAGER" => 'N',
					"DISPLAY_BOTTOM_PAGER" => 'N',
					"PAGER_SHOW_ALWAYS" => 'N',
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PARENT_SECTION" => $arResult['current']['id'],
					"INCLUDE_SUBSECTIONS" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
				),
				$component
			); ?>
		</div>
	<?php endif;?>
	<?php if (!empty($arResult['current']['detail_text'])): ?>
		<div class="content_text"><?php echo $arResult['current']['detail_text']; ?></div>
	<?php endif; ?>
</div>
