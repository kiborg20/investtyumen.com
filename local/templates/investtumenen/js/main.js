// $('#more-nav').moreNav();
$( document ).ready(function(){
    $('.heroslider').slick({
        dots: false,
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: false,
        asNavFor: '.herosubtitleslider, .heropaginslider',
    });
    $('.herosubtitleslider').slick({
        dots: false,
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: false,
        asNavFor: '.heroslider, .heropaginslider',
    });
    $('.heropaginslider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        focusOnSelect: true,
        slidesToShow: 3,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                autoplaySpeed: 5000,
                slidesToShow: 2,
                slidesToScroll: 2,
              }
            }
          ],
        arrows: false,
        asNavFor: '.heroslider, herosubtitleslider',
    });
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
    
    $('.news_topcard_slider').slick({
        slidesToShow: 1,
        arrows: false,
        dots: false,
        infinite: false,
        // asNavFor: '.progressbar__slider, .project__slider-progressbar',
    });
    $('.news_botcard_slider').slick({
        slidesToShow: 1,
        arrows: true,
        prevArrow: '<button type="button" class="slider_arrow slider_arrow_left"> <img src="/img/sliderarrow.svg" alt=""></button>',
        nextArrow: '<button type="button" class="slider_arrow slider_arrow_right"> <img src="/img/sliderarrow.svg" alt=""></button>',
        dots: false,
        infinite: false,
        asNavFor: '.news_topcard_slider',
    });
    

    $('.project_slider').slick({
        slidesToShow: 3,
        prevArrow: '<button type="button" class="slider_arrow slider_arrow_left"> <img src="/img/sliderarrow.svg" alt=""></button>',
        nextArrow: '<button type="button" class="slider_arrow slider_arrow_right"> <img src="/img/sliderarrow.svg" alt=""></button>',
        // asNavFor: '.progressbar__slider, .project__slider-progressbar',
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 700) {
          $('.hdf').addClass('stick');
        } else {
          $('.hdf').removeClass('stick');
        }
    });

    $(".tablink").on("click", function (e) {
        e.preventDefault();
        $('.tablink').removeClass('active');
        $(this).toggleClass('active');
        var t ='.' + $(this).data('target');
        console.log(t);
        $('.tab_content').removeClass('tab_content_active');
        $(t).toggleClass('tab_content_active');
    });

    $(".content_tabs_li_a").on("click", function (e) {
        e.preventDefault();
        $('.content_tabs_li_a').removeClass('content_tabs_li_active');
        $(this).toggleClass('content_tabs_li_active');
        var t ='.' + $(this).data('target');
        console.log(t);
        $('.content_tab').removeClass('content_tab_active');
        $(t).toggleClass('content_tab_active');
    });

    $('#mn').moreNav();
    $( ".burger" ).click(function(){ // задаем функцию при нажатиии на элемент <div>
	    $( ".burger" ).toggleClass('close'); // отображаем, или скрываем элемент
        $( ".mobilemenu" ).toggleClass('show');
	});

});