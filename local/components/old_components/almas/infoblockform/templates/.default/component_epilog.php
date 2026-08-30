<div id="modal_result" class=" modal_result formresult" style="display:none;">
<!--    <img src="--><?//=SITE_TEMPLATE_PATH?><!--/assets/img/done.svg" alt="" class="done">-->
    <h2 class="formresult_header">Спасибо <br>ваша заявка принята.</h2>
    <p class="formresult_text">Мы свяжемся с Вами в ближайшее время.</p>
</div>
<script src="<?=SITE_TEMPLATE_PATH?>/js/inputmask.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/select2/dist/js/select2.full.js"></script>
<script>
    $(document).ready(function(){

        $(".select2_field").select2({
            minimumResultsForSearch: -1
        });

        $(".phonefield").inputmask({
            mask: "+7(999)999-99-99",//params.mask,
            showMaskOnHover: false,
        });


        $(document).on("click",'.add_field', function(e){
            e.preventDefault();
            var box = $(this).prev(".multiple_field");
            var field = box.children(':first').clone();

            box.append(field);
        });

        $('.infoblock_form').submit(function(e){
            e.preventDefault();
            var formElement = document.getElementById("infoblock_form");
            var formdata = new FormData(formElement);
            $.ajax({
                url:params.ajaxpath,
                type:"POST",
                dataType:'html',
                data:formdata,
                processData: false,
                contentType: false,
                success:function(result){
                    console.log('result'+result);
                    Fancybox.show([{ src: "#modal_result", type: "inline" }]);
                }

            });
        });

        $("input[type=text], input[type=email], input[type=password], textarea").each(function(){
            if($(this).val() != ""){
                $(this).addClass("has-content");
            }
        });

        $("input[type=text], input[type=email], input[type=password],input[type=date], textarea").on("focusout", function(){
            if($(this).val() != ""){
                $(this).addClass("has-content");
            }else{
                $(this).removeClass("has-content");
            }
        });

        $("input[type=text], input[type=email], input[type=password], input[type=date], textarea").on("change", function(){
            if($(this).val() != ""){
                $(this).addClass("has-content");
            }else{
                $(this).removeClass("has-content");
            }
        });

        $(".select2 .select2-selection.select2-selection--single").each(function(){
            if($(this).find(".select2-selection__rendered").length && $(this).find(".select2-selection__rendered").is(':not(:empty)')){
                $(this).parents(".select2").addClass("has-content");
            }
        });

        $(".select2 .select2-selection.select2-selection--single").on("focusout change", function(){
            var _this = this;
            setTimeout(function() {
                if($(_this).find(".select2-selection__rendered").length && $(_this).find(".select2-selection__rendered").is(':not(:empty)')){
                    $(_this).parents(".select2").addClass("has-content");
                }
            }, 100)
        });

        $(".select2 .select2-selection.select2-selection--multiple").on("focusout change", function(){
            if($(this).find(".select2-selection__choice").length && $(this).find(".select2-selection__choice").is(':not(:empty)')){
                $(this).parents(".select2").addClass("has-content");
            }else{
                $(this).parents(".select2").removeClass("has-content");
            }
        });

        $('.emailfield').change(function(){
            var email = $('.emailfield').val();
            var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
            var labelval = "E-mail";
            if(re.test(String(email).toLowerCase())==false){
                $('.emaillabel').html("Введен некорректный Email");
                $('.emaillabel').css("color", 'red');
                $(".formsubmit").addClass("disabled");
                $(".formsubmit").attr("disabled",'disabled');
            }else{
                $('.emaillabel').html(labelval);
                $('.emaillabel').css("color", '#808080');
                $(".formsubmit").removeClass("disabled");
                $(".formsubmit").removeAttr("disabled");
            }
        });

        $(document).on('click', '.dadataField', function(){
            var $region = $(this);
            $(".dadataField").suggestions({
                token: "a849b149fc253e21642df0049bbcd31d0aa35581",
                type: "ADDRESS",
                hint: false,
                bounds: "city",
                onSuggestionsFetch: function (suggestions) {
                    suggestions.sort(function(a, b){
                        var nameA=a.value.toLowerCase(), nameB=b.value.toLowerCase()
                        if (nameA < nameB)
                            return -1
                        if (nameA > nameB)
                            return 1
                        return 0
                    })
                },
                constraints: {
                    locations: { country: "*" }
                },
                onSelect: function(suggestion) {

                },
                onSearchError: function() {
                    $("#message").text("Подсказки не работают");
                }
            });
        })

    });
</script>