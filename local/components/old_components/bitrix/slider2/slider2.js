$( document ).ready(function(){
    $('.photoslidertypeone_img').slick({
        focusOnSelect: true,
        variableWidth: true,
        dots: true,
        dotsClass: 'photoslidertypeone_img_pagination',
        arrows: true,
        prevArrow: '<button type="button" class="slider_arrow slider_arrow_left"> <img src="/img/sliderarrow.svg" alt=""></button>',
        nextArrow: '<button type="button" class="slider_arrow slider_arrow_right"> <img src="/img/sliderarrow.svg" alt=""></button>',
        slidesToShow: 3,
        centerMode: true,
        autoplay: true,
        autoplaySpeed: 5000,
    });
});