function searchToObject() {
    var pairs = window.location.search.substring(1).split("&"),
      obj = {},
      pair,
      i;
  
    for ( i in pairs ) {
      if ( pairs[i] === "" ) continue;
  
      pair = pairs[i].split("=");
      obj[ decodeURIComponent( pair[0] ) ] = decodeURIComponent( pair[1] );
    }
  
    return obj;
  }

function pageScrollHandler() {
    const header = document.querySelector('header');
    const headerOffsetTop = header.offsetTop;

    const buttonUp = document.querySelector('.arrow-up__button');

    if (window.scrollY > headerOffsetTop) {
        header.classList.add("sticky");
        buttonUp.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
        buttonUp.classList.remove("sticky");
    }
}

function initFormDropdowns() {
    const body = document.body;
    const DATA_ATTR_NAME = "data-form-select"
    const dropdowns = document.querySelectorAll(`[${DATA_ATTR_NAME}]`);

    body.addEventListener('click', () =>   {
        dropdowns.forEach((dd) => {
            if (dd.classList.contains('opened')) {
                dd.classList.remove('opened');
            }
        });
    });

    dropdowns.forEach((dd) => {
        const DATA_ATTR_VALUE = dd.dataset.formSelect;
        const input = dd.querySelector('input');
        const listOfOptions = dd.querySelectorAll('li');

        let GET_PARAM_NAME = null;
        if (DATA_ATTR_VALUE && DATA_ATTR_VALUE !== "") {
            const parts = DATA_ATTR_VALUE.split(":");
            if (parts[0] === "GET" && parts[1]) {
                GET_PARAM_NAME = parts[1];

                const search = searchToObject()
                if (search[GET_PARAM_NAME]) input.value = search[GET_PARAM_NAME];
            }
        }

        listOfOptions.forEach((option) => {
            option.addEventListener('click', (event) => {
                const value = event.currentTarget.textContent;
                input.value = value;

                if (GET_PARAM_NAME) {
                    const origin = window.location.origin;
                    const path = window.location.pathname;
                    if (option.classList.contains('option-none')) {
                        window.location = `${origin}${path}`;
                    } else {
                        const url = `${origin}${path}?${GET_PARAM_NAME}=${value}`;
                        window.location = url;
                    }
                }
            });
        });

        dd.addEventListener('click', (event) => {
            event.stopPropagation();
            dd.classList.toggle('opened');
        });
    });
}

function initMobileMenu() {
    const headerSearchBtn = document.querySelector('.header__item_search-button');
    if (headerSearchBtn) {
        headerSearchBtn.addEventListener("click", (event) => {
            event.preventDefault();
            const mobileBottomHeader = document.querySelector('.header__bottom');
            if (mobileBottomHeader && !mobileBottomHeader.classList.contains('show')) {
                mobileBottomHeader.classList.add('show');
                headerSearchBtn.querySelector('a').innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.35529 5.23359C6.04525 4.92217 5.54264 4.9221 5.23253 5.23359C4.92249 5.54499 4.92249 6.04991 5.23253 6.36132L10.8783 12.0321L5.29651 17.6387C4.98646 17.9501 4.98646 18.455 5.29651 18.7664C5.60655 19.0779 6.10923 19.0779 6.41927 18.7664L12.0011 13.1599L17.5829 18.7664C17.893 19.0778 18.3957 19.0778 18.7057 18.7664C19.0158 18.455 19.0157 17.9501 18.7057 17.6387L13.1239 12.0321L18.7697 6.36133C19.0797 6.04992 19.0797 5.545 18.7697 5.23359C18.4596 4.92217 17.957 4.92218 17.6469 5.23359L12.0011 10.9044L6.35529 5.23359Z" fill="currentColor"/></svg>';
            } else {
                mobileBottomHeader.classList.remove('show');
                headerSearchBtn.querySelector('a').innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5396 3C6.37558 3 3 6.37559 3 10.5396C3 14.7036 6.37558 18.0792 10.5396 18.0792C12.3016 18.0792 13.9235 17.4739 15.2068 16.4613L19.4857 20.7402C19.8322 21.0866 20.3938 21.0866 20.7402 20.7402C21.0866 20.3938 21.0866 19.8322 20.7402 19.4858L16.4612 15.2069C17.4739 13.9234 18.0792 12.3016 18.0792 10.5396C18.0792 6.37559 14.7036 3 10.5396 3ZM4.77402 10.5396C4.77402 7.35536 7.35534 4.77402 10.5396 4.77402C13.7238 4.77402 16.3052 7.35536 16.3052 10.5396C16.3052 12.132 15.6608 13.5721 14.6164 14.6165C13.5721 15.6608 12.132 16.3052 10.5396 16.3052C7.35534 16.3052 4.77402 13.7239 4.77402 10.5396Z" fill="currentColor"/></svg>';
            }
        });
    }

    const mobileMenuButtons = document.querySelectorAll("[data-mobile-menu]");
    const mobileMenuList = document.querySelectorAll("[data-toggle-menu]");

    if (mobileMenuButtons && mobileMenuButtons.length > 0) {
        mobileMenuButtons.forEach(button => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const current = event.currentTarget;
                const currentClass = current.classList[0];
                const attrLink = current.getAttribute("data-mobile-menu");

                if (attrLink) {
                    const menu = document.querySelector(`[data-menu-${attrLink}]`);

                    if (menu) {
                        const menuClass = menu.classList[0];
                        const closeButton = menu.querySelector(".menu-list__close");

                        menu.classList.toggle(`${menuClass}_visible`);
                        current.classList.toggle(`${currentClass}_current`);

                        closeButton.addEventListener("click", (event) => {
                            event.preventDefault();

                            menu.classList.remove(`${menuClass}_visible`);
                            current.classList.remove(`${currentClass}_current`);
                        });
                    }
                }
            });
        });
    }

    if (mobileMenuList && mobileMenuList.length > 0) {
        mobileMenuList.forEach(menu => {
            menu.addEventListener("click", (event) => {
                event.preventDefault();

                const current = event.currentTarget;

                current.classList.toggle("current");
            });
        });
    }
}

/*
function initMainSlider() {
    const mainSlideButtons = document.querySelectorAll("[data-slide-list]");

    if (mainSlideButtons && mainSlideButtons.length > 0) {
        mainSlideButtons.forEach(button => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const current = event.currentTarget;

                const attr = current.getAttribute("data-slide-list");

                if (attr) {
                    const slide = document.querySelector(`[data-slide-${attr}]`);

                    if (slide) {
                        const slideClass = slide.classList[0] || null;
                        const classVisible = `${slideClass}_visible`;

                        const wrapper = slide.parentNode;
                        const elements = wrapper.getElementsByClassName(slideClass);

                        [...elements].forEach(item => item.classList.remove(classVisible));
                        mainSlideButtons.forEach(item => item.classList.remove("current"));

                        slide.classList.add(classVisible);

                        current.classList.add("current");
                    }
                }
            });
        });
    }
}
*/

function initMainSlider() {
    const mainSlideButtons = document.querySelectorAll("[data-slide-list]");

    if (mainSlideButtons && mainSlideButtons.length > 0) {
        const showSlide = (current) => {
            const attr = current.getAttribute("data-slide-list");

            if (!attr) {
                return;
            }

            const slide = document.querySelector(`[data-slide-${attr}]`);

            if (!slide) {
                return;
            }

            const slideClass = slide.classList[0] || null;
            const classVisible = `${slideClass}_visible`;

            const wrapper = slide.parentNode;
            const elements = wrapper.getElementsByClassName(slideClass);

            [...elements].forEach(item => item.classList.remove(classVisible));
            mainSlideButtons.forEach(item => item.classList.remove("current"));

            slide.classList.add(classVisible);
            current.classList.add("current");
        };

        mainSlideButtons.forEach(button => {
            button.addEventListener("mouseenter", (event) => {
                showSlide(event.currentTarget);
            });
        });
    }
}

function initSwipeSliders() {
    const integerFn = (value) => (value - value % 2) / 2 < 1;

    const fullSLiders = document.querySelectorAll("[data-full-slider]");

    [...fullSLiders].forEach((slider) => {
        const wrapperClass = slider.classList[0];
        const sliderView = slider.getAttribute("data-slider-view") || null;
        let slidesPerView = +sliderView;

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
            },
            breakpoints: {
                320: {
                    slidesPerView: "auto",
                },
                1270: {
                    slidesPerView
                }
            }
        });
    });
}

function initSwiperContainers() {
    const swiperElements = document.querySelectorAll('swiper-container');
    const params = {
        watchSlidesProgress: true,
        injectStyles: [`
        .swiper-pagination {
            top: 16px !important;
            display: flex;
            height: 8px;
        }

        .swiper-pagination-bullet {
          width: auto;
          height: 4px;
          background: #fff;
          border-radius: 2px;
          opacity: 0.4;
          flex: 1;
        }
  
        .swiper-pagination-bullet:first-child {
          margin-left: 16px !important;
        }

        .swiper-pagination-bullet:last-child {
          margin-right: 16px !important;
        }
  
        .swiper-pagination-bullet-active {
          opacity: 1;
        }
        `],
        pagination: {
          clickable: true,
          renderBullet: function (index, className) {
            return '<span class="' + className + '"/>' + '&nbsp;' + "</span>";
          },
        },
      }
  
      swiperElements.forEach((swiperEl) => {
        Object.assign(swiperEl, params)
  
        swiperEl.initialize();
      })
}

function initAccordeons() {
    const toggleItems = document.querySelectorAll("[data-toggle]");

    if (toggleItems && toggleItems.length > 0) {
      toggleItems.forEach((toggle, index) => {
        const toggleACtion = toggle.querySelector("[data-toggle-action]");
        const wrapperClass = toggle.classList[0] || null;
        const expandedClass = `${wrapperClass}_expanded`;
  
        if (toggleACtion && wrapperClass) {
          toggleACtion.addEventListener("click", (event) => {
            event.preventDefault();
  
            toggleItems.forEach((item, i) => {
              if (item.classList.contains(expandedClass) && index !== i) {
                item.classList.remove(expandedClass);
              }
            });
  
            toggle.classList.toggle(expandedClass);
          });
        }
      });
    }
}

function initUpButton() {
    const buttonUp = document.querySelector('.arrow-up__button');

    if (buttonUp) {
        buttonUp.addEventListener("click", (event) => {
            event.preventDefault();
  
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: "smooth",
              }); 
          });
    }
}

function UrlExists(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    if (http.status != 404)
        return true;
    else
        return false;
}

function phoneMask() {
    Inputmask({
        mask: "+7 (999) 999 9999",
        removeMaskOnSubmit: true, // Удаляет маску при отправке формы
        showMaskOnHover: false,   // Не показывать маску при наведении
        clearIncomplete: false,     // Очищать неполные значения
        placeholder: "_" // Убирает стандартный подчёркивание, если нужно
    }).mask('[data-phone-mask]');
}

document.addEventListener("DOMContentLoaded", () => {
    const html = document.getElementsByTagName("html")[0];
    var url = window.location.href;
    if (UrlExists(url)) {
        html.classList.remove('not-found');
        window.addEventListener('scroll', pageScrollHandler);

        const head = document.getElementsByTagName("head")[0];
        const link = document.createElement("link");
    
        link.rel = "stylesheet";
        link.type = "text/css";
        link.href = "https://cdn.jsdelivr.net/npm/swiper@9.4.1/swiper-bundle.min.css";
        link.media = "all";
    
        head.appendChild(link);

        initUpButton();
        initFormDropdowns();
        initMobileMenu();    
        initMainSlider();
        initSwipeSliders();
        initSwiperContainers();
        initAccordeons();
        phoneMask();
    } else {
        html.classList.add('not-found');
    }
});