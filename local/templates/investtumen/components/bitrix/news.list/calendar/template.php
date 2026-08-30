<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);

$events = [];
$this->addExternalCss("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css");
$this->addExternalJS("https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js");

foreach($arResult["ITEMS"] as $item){


    $event = [];
    $event['title'] = $item['NAME'];
    $event['start'] = date("Y-m-d",strtotime($item['PROPERTIES']['EVENT_DATE']["VALUE"]));
    $event['url'] = $item["DETAIL_PAGE_URL"];
    $event["extendedProps"] = [
        "elid"=> $item['ID'],
        'description'=>$item["PREVIEW_TEXT"]
      ];

    $events[] = $event;
}

?>
<script>
    var eventsdates = <?=CUtil::PhpToJSObject($events)?>;

</script>

<div id='calendar'>

</div>

<div id="modalevent" style="display:none">
    <div class="eventTitle"></div>
    <div class="eventDescription"></div>
    <a href="#" class="eventlink">Подробнее</a>
</div>
