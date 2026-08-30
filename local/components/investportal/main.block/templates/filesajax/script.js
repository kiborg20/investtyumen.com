document.addEventListener("DOMContentLoaded", () => {
  const handlerButtons = document.querySelectorAll("[data-list-handler]");

  if (handlerButtons && handlerButtons.length > 0) {
    handlerButtons.forEach(button => {
      button.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;

        const wrapper = current.parentNode;

        if (wrapper) {
          const list = wrapper.querySelector("[data-list]");

          if (list) {
            const listClass = list.classList[0] || null;

            if (listClass) {
              const hiddenClass = `${listClass}__item_hidden`;
              const hiddenItem = list.querySelectorAll("." + hiddenClass);

              if (hiddenItem && hiddenItem.length > 0) {
                hiddenItem.forEach(item => item.classList.remove(hiddenClass));

                current.style.display = "none";
              }
            }
          }
        }
      });
    });
  }
});
