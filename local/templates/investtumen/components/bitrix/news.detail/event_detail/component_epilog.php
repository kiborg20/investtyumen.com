<li class="switcher_container">
    <div class="form_preview_text">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/personal/include/event_form.php"
            )
        );?>
    </div>
    <?

    $APPLICATION->IncludeComponent(
        "almas:infoblockform",
        "event",
        array(
            "IBLOCK_TYPE" => 'profile',
            "IBLOCK_ID" => '42',
            "EVENT"=>$arResult['EVENT_DATA'],
        ),
        false
    ); ?>
</li>
</ul>

</div>

<a href="#" onclick="javascript:history.back(); return false;" class="back_to_event">Вернуться к списку мероприятий</a>

<?$APPLICATION->setTitle($arResult['MY_TITLE']);?>