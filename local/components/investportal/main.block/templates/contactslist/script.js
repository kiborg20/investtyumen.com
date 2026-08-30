function initVCardButtons() {
  const buttons = document.querySelectorAll('[data-person-vcard-button]');
  [...buttons]?.forEach((button) => {

      button.addEventListener("click", (e) => e.stopPropagation());

      const name = button.getAttribute('data-person-vcard-name');
      const position = button.getAttribute('data-person-vcard-position');
      const phone = button.getAttribute('data-person-vcard-phone');
      const email = button.getAttribute('data-person-vcard-email');

      var personCard = vCard.create(vCard.Version.FOUR);
      personCard.add(vCard.Entry.NAME, name);
      personCard.add(vCard.Entry.TITLE, position);
      personCard.add(vCard.Entry.PHONE, phone, vCard.Type.CELL);
      personCard.add(vCard.Entry.EMAIL, email, vCard.Type.WORK);
      var link = vCard.export(personCard, name, false);

      button.download = link.download;
      button.href = link.href;
  })
};

document.addEventListener("DOMContentLoaded", () => {
  initVCardButtons();
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
