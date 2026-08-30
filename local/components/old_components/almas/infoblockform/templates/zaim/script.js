(function($) {
    function setChecked(target) {
        var checked = $(target).find("input[type='checkbox']:checked").length;
        if (checked) {
            $(target).find('select option:first').html('Выбрано: ' + checked);
        } else {
            $(target).find('select option:first').html('Выберите из списка');
        }
    }

    $.fn.checkselect = function() {
        this.wrapInner('<div class="checkselect-popup"></div>');
        this.prepend(
            '<div class="checkselect-control">' +
            '<select class="form-control"><option></option></select>' +
            '<div class="checkselect-over"></div>' +
            '</div>'
        );

        this.each(function(){
            setChecked(this);
        });
        this.find('input[type="checkbox"]').click(function(){
            setChecked($(this).parents('.checkselect'));
        });

        // this.parent().find('.checkselect-control').on('click', function(){
        //     $popup = $(this).next();
        //     $('.checkselect-popup').not($popup).css('display', 'none');
        //     if ($popup.is(':hidden')) {
        //         $popup.css('display', 'block');
        //         $(this).find('select').focus();
        //     } else {
        //         $popup.css('display', 'none');
        //     }
        // });

        // $('html, body').on('click', function(e){
        //     if ($(e.target).closest('.checkselect').length == 0){
        //         $('.checkselect-popup').css('display', 'none');
        //     }
        // });
    };
})(jQuery);

$(document).ready(function () {
    $('.checkselect').checkselect();

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

    $('.infoblock_form').submit(function (e) {
        e.preventDefault();
        var formElement = document.getElementById("infoblock_form");
        var formdata = new FormData(formElement);
        $.ajax({
            url: fparams.ajaxpath,
            type: "POST",
            dataType: 'html',
            data: formdata,
            processData: false,
            contentType: false,
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


});