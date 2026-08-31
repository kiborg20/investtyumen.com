document.addEventListener("DOMContentLoaded", () => {
  const mainSlider = document.querySelector(".hero-with-sidebar .main-slider");

  if (!mainSlider) {
    return;
  }

  new Swiper(mainSlider, {
    autoplay: {
      enabled: true,
      delay: 2000,
      pauseOnMouseEnter: true,
      disableOnInteraction: false,
    },
    speed: 2500,
    effect: "fade",
    loop: true,
    slideNextClass: "main-slider__item_next",
    slideActiveClass: "main-slider__item_current",
    slidesPerView: 1,
    stopOnLastSlide: false,
  });
});
