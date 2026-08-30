document.addEventListener("DOMContentLoaded", () => {
  const mainSlider = document.querySelector(".main-slider");

  const swiper = new Swiper(mainSlider, {
    autoplay: {
      delay: 2500,
    },
    speed: 600,
    direction: "vertical",
    effect: "creative",
    loop: true,
    slideNextClass: "main-slider__item_next",
    slideActiveClass: "main-slider__item_current"
  });
});
