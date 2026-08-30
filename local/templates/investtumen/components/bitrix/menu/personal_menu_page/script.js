$(document).ready(function(){



    $('.personal_page_menue').slick({
        slidesToShow:5,
        slidesToScroll:2,
        autoplay:false,
        arrows:true,
        prevArrow: '<button type="button" class="slider_arrow slider_arrow_left"> <img src="/img/sliderarrow.svg" alt=""></button>',
        nextArrow: '<button type="button" class="slider_arrow slider_arrow_right"> <img src="/img/sliderarrow.svg" alt=""></button>',
        dots:false,
        infinite:true,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    arrows:true,
                }
            },

            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    arrows:true,
                }
            },
            {
                breakpoint: 570,
                settings: {
                    slidesToShow: 2,
                    arrows:true,
                }
            },
            {
                breakpoint: 420,
                settings: {
                    slidesToShow: 1,
                    arrows:true,
                }
            }
        ]

    });

    $('.activeSlickSlide').each(function(){
        if($(this).closest('.slick-slide').hasClass("slick-cloned")===false){
            console.log("el  ",$(this).closest('.slick-slide').data('slick-index'));
            curindex = $(this).closest('.slick-slide').data('slick-index');
            $('.personal_page_menue').slick('goTo', curindex);
            console.log("index1 ",curindex);

        }
    });

});