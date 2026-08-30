<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
?>

<section class="section">
    <div class="wrapper wrapper_mode-l">
        <div class="breadscrumbs">
            <div class="breadscrumbs__button">
                <a onclick="history.back()" href="#">
                    <span class="button button_theme-transparent button_size-s button_padding-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#252830" stroke="#4A66F5" d="M13.651 7.707a.25.25 0 1 0-.354-.354l-4.469 4.47a.25.25 0 0 0 0 .354l4.823-4.47Zm0 0-3.939 3.94-.354.353m4.293-4.293L9.358 12m0 0 .354.354M9.358 12l.354.354m0 0 3.94 3.939m-3.94-3.94 3.94 3.94m0 0a.25.25 0 0 1 0 .354v-.354Zm-.354.354-4.47-4.47 4.823 4.47a.25.25 0 0 1-.353 0Z"/></svg></span>
                    Назад
                </a>
            </div>

            <div class="breadscrumbs__links">
                <a class="breadscrumbs__item" href="/">Главная</a>
                <span class="breadscrumbs__item">/</span>
                <span class="breadscrumbs__item">Результаты поиска</span>
            </div>
        </div>
    </div>
</section>

<?$APPLICATION->IncludeComponent(
  'investportal:search',
  '.default'
);
return;
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"itsearch", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "50",
		"RESTART" => "Y",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "N",
		"arrFILTER" => array(
			0 => "no",
		),
		"arrWHERE" => "",
		"COMPONENT_TEMPLATE" => "itsearch",
		"SHOW_ITEM_TAGS" => "Y",
		"TAGS_INHERIT" => "Y",
		"SHOW_ITEM_DATE_CHANGE" => "Y",
		"SHOW_ORDER_BY" => "Y",
		"SHOW_TAGS_CLOUD" => "N",
		"STRUCTURE_FILTER" => "structure",
		"NAME_TEMPLATE" => "",
		"SHOW_LOGIN" => "Y",
		"TAGS_SORT" => "NAME",
		"TAGS_PAGE_ELEMENTS" => "150",
		"TAGS_PERIOD" => "",
		"TAGS_URL_SEARCH" => "",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"COLOR_NEW" => "000000",
		"COLOR_OLD" => "C8C8C8",
		"PERIOD_NEW_TAGS" => "",
		"SHOW_CHAIN" => "Y",
		"COLOR_TYPE" => "Y",
		"WIDTH" => "100%",
		"arrFILTER_main" => ""
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>