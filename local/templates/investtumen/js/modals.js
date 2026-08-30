document.addEventListener("DOMContentLoaded", () => {
    const buttonsModalHandler = document.querySelectorAll("[data-open-modal]");

    if (buttonsModalHandler && buttonsModalHandler.length > 0) {
        buttonsModalHandler.forEach(button => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const current = event.currentTarget;
                const attrModal = current.getAttribute("data-open-modal");

                if (attrModal) {
                    const wrapper = document.querySelector(`[data-${attrModal}]`);

                    if (wrapper && event.target.getAttribute("data-close-modal") === null) {
                        wrapper.classList.add("modal-wrapper_opened");
                    }

                    const closeButton = wrapper.querySelector("[data-close-modal]");
                    if (closeButton) {
                        closeButton.addEventListener("click", (event) => {
                            event.preventDefault();
            
                            const current = event.currentTarget;
                            const wrapper = wrapperSelector(current, "modal-wrapper");
            
                            if (wrapper) {
                                const fields = wrapper.querySelectorAll('.field-wrapper');
                                if (fields && fields.length) {
                                    fields.forEach((field) => field.classList.remove('error'));
                                }

                                const footer = wrapper.querySelector('.modal-wrapper__footer');

                                if (footer) {
                                    const errorBlock = footer.querySelector('.modal-wrapper_error-message');                    
                                    if (errorBlock) { errorBlock.classList.remove('show'); }
                
                                    const resultBlock = wrapper.querySelector('.modal-wrapper__content-result');
                                    if (resultBlock) { resultBlock.classList.remove('show'); }
                
                                    const form = wrapper.querySelector('form');
                                    if (form) { form.reset(); }
                                }
                                
                                wrapper.classList.remove("modal-wrapper_opened");
                            }
                        });
                    }
                }
            });
        });
    }
});