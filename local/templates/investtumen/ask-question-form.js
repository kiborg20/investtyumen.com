function handleSubmitAskForm(json, requiredFields, modalWrapper) {
    const fieldsError = validateConsultForm(json, requiredFields);
    const footer = modalWrapper.querySelector('.modal-wrapper__footer');
    console.log(fieldsError);
    console.log(footer);
    console.log(json);
    console.log(requiredFields);
    console.log(modalWrapper);
    
    
    
    

    if (Object.keys(fieldsError).length === 0) {
        postAjax("/api/getConsultation", json)
            .then((result) => {
                console.log(result);
                
                modalWrapper.querySelector('.modal-wrapper__content-result').classList.add('show');
            })
            .catch((error) => {
                displayError(footer, "Не удалось отправить вопрос. Попробуйте повторить позднее.");
                console.log(error);
            })
    } else {
        Object.keys(fieldsError).forEach((field) => {
            const formControl = modalWrapper.querySelector(`#form-field-${field}`);
            if (formControl) {
                formControl.classList.add("error");
            }
        })
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.querySelector(`[data-ask-question]`);

    initModalFooter(wrapper, handleSubmitAskForm);
});