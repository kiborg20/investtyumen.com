document.addEventListener("DOMContentLoaded", () => {
  const mainSlider = document.querySelector(".main-slider");

  const swiper = new Swiper(mainSlider, {
    autoplay: {
      enabled: true,
      delay: 2000,
    },
    speed: 1000,
    effect: "fade",
    loop: true,
    //slideNextClass: "main-slider__item_next",
    //slideActiveClass: "main-slider__item_current",
    slidesPerView: 1,
    stopOnLastSlide: false,

    /** Enable to release touch events on slider edge position (beginning, end) to allow for further page scrolling. 
     * This feature works only with "touch" events (and not pointer events), 
     * so it will work on iOS/Android devices and won't work on Windows devices with pointer events. 
     * Also threshold parameter must be set to 0 */
    //touchReleaseOnEdges: true,
    //threshold: 0,
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const ACTIVE_TAB = "blue";
  const DEFAULT_TAB = "transparent";
  const THEME_CLASS = "button_theme-";

  const actionTabs = document.querySelectorAll("[data-tab]");
  const categories = document.querySelectorAll("[data-category]");

  const categoryVisible = (tabId) => {
    if (categories && categories.length > 0) {
      categories.forEach((category) => {
        const categoryId = category.getAttribute("data-category");
        const categoryClass = category.classList[0] || null;

        if (categoryId && +categoryId !== +tabId) {
          category.classList.add(`${categoryClass}_hidden`);

          return false;
        }

        category.classList.remove(`${categoryClass}_hidden`);
      });
    }
  };

  categoryVisible(1);

  if (actionTabs && actionTabs.length > 0) {
    actionTabs.forEach((tab) => {
      tab.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;
        const tabId = current.getAttribute("data-tab");

        actionTabs.forEach((item) => {
          if (item.classList.contains(`${THEME_CLASS}${ACTIVE_TAB}`)) {
            item.classList.replace(
              `${THEME_CLASS}${ACTIVE_TAB}`,
              `${THEME_CLASS}${DEFAULT_TAB}`
            );
          }
        });

        current.classList.replace(
          `${THEME_CLASS}${DEFAULT_TAB}`,
          `${THEME_CLASS}${ACTIVE_TAB}`
        );

        categoryVisible(tabId);
      });
    });
  }
});
