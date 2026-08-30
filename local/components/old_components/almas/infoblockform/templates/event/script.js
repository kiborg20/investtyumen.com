$(document).ready(function () {

    $(".select2_field").select2({
        minimumResultsForSearch: -1
    });

    $(".phonefield").inputmask({
        mask: "+7(999)999-99-99",
        showMaskOnHover: false,
    });


    $(document).on("click", '.add_field', function (e) {
        e.preventDefault();
        var box = $(this).prev(".multiple_field");
        var field = box.children(':first').clone();

        box.append(field);
    });

    $(document).on("submit",'.infoblock_form', function (e) {
        e.preventDefault();

        var users = [];
            user = [],
            formdata = [];

        user["name"] = $(".contactblock.first_contact .username").val();
        user["phone"] = $(".contactblock.first_contact .userphone").val();
        user["email"] = $(".contactblock.first_contact .useremail").val();

        users.push(user);

        if($(".dop_contacts_wrapper .contactblock").length>0){
            tempuser = [];
            $(".dop_contacts_wrapper .contactblock").each(function(){
                tempuser["name"] = $(this).find(".username").val();
                tempuser["phone"] = $(this).find(".userphone").val();
                tempuser["email"] = $(this).find(".useremail").val();

                users.push(tempuser);
            });
        }


        formdata["USERS"] = $.extend({}, users);
        formdata["EVENT_NAME"] = $(".event_name").val();
        formdata["EVENT_THEME"] = $(".event_theme").val();
        formdata["EVENT_DATE"] = $(".event_date").val();
        formdata["EVENT_TIME"] = $(".event_time").val();
        formdata["EVENT_PLACE"] = $(".event_place").val();
        formdata["INITIATOR"] = $(".initiator").val();
        formdata["INITIATOR_INN"] = $(".initiator_inn").val();
        formdata["iblockID"] = fparams.iblock_id;

       console.log($.extend({}, formdata));


        formdata = $(this).serialize();
        $.ajax({
            url: fparams.ajaxpath,
            type: "POST",
            dataType: 'html',
            traditional: true,
            data: formdata,//{
                //"USERS": $.extend({}, users),
                // "EVENT_NAME":$(".event_name").val(),
                // "EVENT_THEME":$(".event_theme").val(),
                // "EVENT_DATE":$(".event_date").val(),
                // "EVENT_TIME":$(".event_time").val(),
                // "EVENT_PLACE":$(".event_place").val(),
                // "INITIATOR":$(".initiator").val(),
                // "INITIATOR_INN":$(".initiator_inn").val(),
                // "iblockID":fparams.iblock_id

            //},
            success: function (result) {
                console.log('result' + result);
                $('.formresult').html(result);
                Fancybox.show([{src: "#modal_result", type: "inline"}]);
            }

        });
    });

    $("input[type=text], input[type=email], input[type=password], textarea").each(function () {
        if ($(this).val() != "") {
            $(this).addClass("has-content");
        }
    });

    $("input[type=text], input[type=email], input[type=password],input[type=date], textarea").on("focusout", function () {
        if ($(this).val() != "") {
            $(this).addClass("has-content");
        } else {
            $(this).removeClass("has-content");
        }
    });

    $("input[type=text], input[type=email], input[type=password], input[type=date], textarea").on("change", function () {
        if ($(this).val() != "") {
            $(this).addClass("has-content");
        } else {
            $(this).removeClass("has-content");
        }
    });

    $(".select2 .select2-selection.select2-selection--single").each(function () {
        if ($(this).find(".select2-selection__rendered").length && $(this).find(".select2-selection__rendered").is(':not(:empty)')) {
            $(this).parents(".select2").addClass("has-content");
        }
    });

    $(".select2 .select2-selection.select2-selection--single").on("focusout change", function () {
        var _this = this;
        setTimeout(function () {
            if ($(_this).find(".select2-selection__rendered").length && $(_this).find(".select2-selection__rendered").is(':not(:empty)')) {
                $(_this).parents(".select2").addClass("has-content");
            }
        }, 100)
    });

    $(".select2 .select2-selection.select2-selection--multiple").on("focusout change", function () {
        if ($(this).find(".select2-selection__choice").length && $(this).find(".select2-selection__choice").is(':not(:empty)')) {
            $(this).parents(".select2").addClass("has-content");
        } else {
            $(this).parents(".select2").removeClass("has-content");
        }
    });

    $('.formfile').change(function () {

        var countFiles = '',
            label = $(this).next('.input__file-button'),
            labelVal1 = label.find('.input__file-button-text').text();

        if ($(this)[0].files && $(this)[0].files.length >= 1) {
            countFiles = Number($(this)[0].files.length);
        }

        if (countFiles > 0) {
            labelVal1 = 'Выбрано файлов: ' + countFiles;
        }

        var res = label.children('span.input__file-button-text');
        res.html(labelVal1);

    });

    $(".inoe_lico").change(function(){
        if(!$(this).is(":checked")){
            $(".username").val(curuser.name);
            $(".userphone").val(curuser.phone);
            $(".useremail").val(curuser.email);
        }else if($(this).is(":checked")){
            $(".username").val("");
            $(".userphone").val("");
            $(".useremail").val("");
        }
    });

    $(".adduser").click(function(e){
       e.preventDefault();
       $(".dop_contacts_wrapper").append('<div class="contactblock"><div class="userdelete"></div><div class="form_fieldset"><label for="" class="formlabel required_field ">Участник</label><input type="text" class="username" name="USERNAME[]" value="" required></div><div class="form_fieldset"><label for="" class="formlabel required_field ">Телефон</label><input type="text" class="phonefield userphone" name="USERPHONE[]" value="" required ></div><div class="form_fieldset"><label for="" class="formlabel required_field ">Электронная почта</label><input type="text" class="useremail" name="USEREMAIL[]" value="" required ></div></div>');
        $(".phonefield").inputmask({
            mask: "+7(999)999-99-99",
            showMaskOnHover: false,
        });
    });

    $(document).on("click",".userdelete",function(){
        $(this).closest(".contactblock").remove();
    });

});