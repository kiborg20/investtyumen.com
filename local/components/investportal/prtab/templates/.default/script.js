document.addEventListener("DOMContentLoaded", () => {
  const ACTIVE_TAB = "blue";
  const DEFAULT_TAB = "transparent";
  const THEME_CLASS = "button_theme-";

  const actionTabs = document.querySelectorAll("[data-tab]");
  const categories = document.querySelectorAll("[data-category]");

  const categoryVisible = (tabId) => {
    if (categories && categories.length > 0) {
      categories.forEach(category => {
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
    actionTabs.forEach(tab => {
      tab.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;
        const tabId = current.getAttribute("data-tab");

        actionTabs.forEach(item => {
          if (item.classList.contains(`${THEME_CLASS}${ACTIVE_TAB}`)) {
            item.classList.replace(`${THEME_CLASS}${ACTIVE_TAB}`, `${THEME_CLASS}${DEFAULT_TAB}`);
          }
        });

        current.classList.replace(`${THEME_CLASS}${DEFAULT_TAB}`, `${THEME_CLASS}${ACTIVE_TAB}`);

        categoryVisible(tabId);
      });
    });
  }
});
