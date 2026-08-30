const WHITE_THEME = "section_theme-white";
const CLASS_SCROLL = "scroll-disabled";

const querySelector = (attr) => document.querySelectorAll(`[${attr}]`);

const wrapperSelector = (current, className) => {
  const container = current.parentNode;
  if (container.classList.contains(className)) {
    return container;
  }

  return wrapperSelector(container, className);
};

const coreClassName = (selector) => {
  return selector.classList.length && selector.classList[0] || null;
}

const getScrollbarWidth = () => {
  return window.innerWidth - document.documentElement.clientWidth;
}

function initHeaderSearch() {
  const handleAttr = "data-search-header";
  const buttonsSearch = querySelector(handleAttr);

  if (buttonsSearch && buttonsSearch.length) {
    buttonsSearch.forEach(button => {
      button.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;
        const attrClass = current.getAttribute(handleAttr);
        const searchWrapper = document.querySelector(`.${attrClass}`);
        const wrapperClass = coreClassName(searchWrapper);

        searchWrapper.classList.toggle(`${wrapperClass}_opened`);
      });
    });
  }
}

function initLanguageSelect() {
  const dropdowns = querySelector("data-dropdown-label");

  if (dropdowns && dropdowns.length) {
    dropdowns.forEach(dropdown => {
      dropdown.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;
        const wrapper = wrapperSelector(current, "dropdown");
        const list = wrapper.querySelector("[data-dropdown-list]");

        if (list) {
          const listClass = coreClassName(list);

          listClass && list.classList.toggle(`${listClass}_opened`);
          wrapper && wrapper.classList.toggle("dropdown_opened");
        }
      });
    });
  }
}

function initSubmenu() {
  const handlersMenu = querySelector("data-submenu");

  if (handlersMenu && handlersMenu.length) {
    handlersMenu.forEach((link, index) => {
      link.addEventListener("click", (event) => {
        event.preventDefault();


        const DATA_OPENED = "data-opened";

        const current = event.currentTarget;
        const submenu = current.parentNode.querySelector(".submenu-container-overlay");
        const body = document.body;
        const root = document.documentElement;

        if (submenu) {
          const currentClass = coreClassName(submenu);
          const wrapperHeader = wrapperSelector(current, "section");

          const buttonThemeOpened = wrapperHeader.querySelector("[data-button]");
          const buttonCloseSubmenu = submenu.querySelector(`[data-submenu-button-close]`);

          const buttonClassTheme = buttonThemeOpened.getAttribute("data-button");

          handlersMenu.forEach(item => item.classList.remove("header-menu__link_current"));

          current.classList.add("header-menu__link_current");
          submenu.setAttribute(DATA_OPENED, index);

          if (buttonCloseSubmenu) {
            buttonCloseSubmenu.addEventListener("click", (event) => {
              event.preventDefault();
              body.classList.remove(CLASS_SCROLL);

              if (wrapperHeader) {
                wrapperHeader.classList.remove(WHITE_THEME);
                buttonClassTheme && buttonThemeOpened.classList.remove(buttonClassTheme);
                current.classList.remove("header-menu__link_current");
              }
            });
          }

          if (!body.classList.contains(CLASS_SCROLL)) {
            root.style.setProperty("--scrollbarWidth", `${getScrollbarWidth()}px`);
          }

          body.classList.add(CLASS_SCROLL);

          if (wrapperHeader) {
            wrapperHeader.classList.add(WHITE_THEME);
            buttonClassTheme && buttonThemeOpened.classList.add(buttonClassTheme);
          }

          if (currentClass) {
            submenu.classList.toggle(`modal-wrapper_opened`);

            const openedMenu = document.querySelectorAll(`.${currentClass}.modal-wrapper_opened`);
            if (openedMenu && openedMenu.length === 0) {
              body.classList.remove(CLASS_SCROLL);

              if (wrapperHeader) {
                wrapperHeader.classList.remove(WHITE_THEME);
                buttonClassTheme && buttonThemeOpened.classList.remove(buttonClassTheme);
                current.classList.remove("header-menu__link_current");
              }
            }

            openedMenu.forEach(menu => {
              const attrOpened = menu.getAttribute(DATA_OPENED);

              if (attrOpened && +attrOpened !== index) {
                menu.classList.remove(`modal-wrapper_opened`);
              }
            });
          }
        }
      });
    });
  }
}

function initTabletMenu() {
  const buttonOpenMenu = document.querySelector("[data-tablet-menu]");

  if (buttonOpenMenu) {
    buttonOpenMenu.addEventListener("click", (event) => {
      event.preventDefault();

      const current = event.currentTarget;
      const tabletMenu = document.querySelector(".modal-menu-tablet");
      const body = document.body;
      const root = document.documentElement;

      if (tabletMenu) {
        const menuClass = tabletMenu.classList[0] || null;

        if (!body.classList.contains(CLASS_SCROLL)) {
          root.style.setProperty("--scrollbarWidth", `${getScrollbarWidth()}px`);
        }

        if (menuClass) {
          current.classList.toggle("active");
          tabletMenu.classList.toggle(`${menuClass}_visible`);

          const wrapperHeader = wrapperSelector(current, "section");

          if (wrapperHeader) {
            const buttonThemeOpened = wrapperHeader.querySelector("[data-button]");

            const buttonClassTheme = buttonThemeOpened.getAttribute("data-button");

            wrapperHeader.classList.toggle(WHITE_THEME);
            buttonClassTheme && buttonThemeOpened.classList.toggle(buttonClassTheme);

            body.classList.toggle(CLASS_SCROLL);
          }
        }
      }
    });
  }

  const toggleMenu = document.querySelectorAll("[data-handler-menu]");

  if (toggleMenu && toggleMenu.length > 0) {
    toggleMenu.forEach(menu => {
      menu.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;

        const wrapper = wrapperSelector(current, "toggle-menu__item");

        if (wrapper) {
          wrapper.classList.toggle("toggle-menu__item_current");
        }
      });
    });
  }
}

function bodyClickHandler(event) {
  const element = event.target;
  const clickedOnMenu = element?.hasAttribute('data-submenu') || 
                        element.classList.contains('submenu') || 
                        element.classList.contains('submenu__item') || 
                        element.parentNode?.classList.contains('submenu__item') ||
                        element.parentNode?.parentNode?.classList.contains('submenu__item') ||
                        element.classList.contains('header__item_search-button') || 
                        element.parentNode?.classList.contains('header__item_search-button') || 
                        element.parentNode?.parentNode?.classList.contains('header__item_search-button');

  if (!clickedOnMenu) {
    document.body.classList.remove(CLASS_SCROLL);
    const menuItems = document.querySelectorAll(`.submenu-container-overlay`);

    menuItems.forEach(submenu => {      
      const wrapperHeader = wrapperSelector(submenu, "section");
      const buttonThemeOpened = wrapperHeader.querySelector("[data-button]");
      const buttonClassTheme = buttonThemeOpened.getAttribute("data-button");
      submenu.classList.remove('modal-wrapper_opened');
      wrapperHeader.classList.remove(WHITE_THEME);
      buttonClassTheme && buttonThemeOpened.classList.remove(buttonClassTheme);
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document.body.addEventListener('click', bodyClickHandler);

  initHeaderSearch();

  initLanguageSelect();

  initSubmenu();

  initTabletMenu();
});
