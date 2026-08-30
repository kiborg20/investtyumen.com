document.addEventListener("DOMContentLoaded", () => {
  const integerFn = (value) => (value - value % 2) / 2 < 1;

  const fullSLiders = document.querySelectorAll("[data-full-slider]");

  [...fullSLiders].forEach((slider) => {
    const wrapperClass = slider.classList[0];
    const sliderView = slider.getAttribute("data-slider-view") || null;
    let slidesPerView = "auto";

    if (sliderView) {
      slidesPerView = integerFn(+sliderView) ? "auto" : sliderView;
    }

    if (slidesPerView === "auto") {
      slider.classList.add(`${wrapperClass}_auto`);
    }

    const swiper = new Swiper(slider, {
      speed: 600,
      slidesPerView,
      spaceBetween: 24,
      navigation: {
        nextEl: ".full-slider__nav_next",
        prevEl: ".full-slider__nav_prev",
      }
    });
  });
});
