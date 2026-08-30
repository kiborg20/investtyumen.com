<?if(count($arResult["ELEMENTS"])>0){?>
    <script>
        $(document).ready(function(){
            $("<?echo "#zaim_table_".$arParams['IBLOCK_ID'].$arParams['TABLE_ID_PREFFIX']?>").DataTable({
                sDom: '<"top"i>rt<"bottom"lp><"clear">',
                "info": false,
                "iDisplayLength": 50,
                "bLengthChange": false,
                language: {
                    url: '/local/templates/investtumen/js/DataTables/ru.json',

                }
            });
        });
    </script>

<?}?>

