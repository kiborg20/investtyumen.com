const getFileSize = (bytes = 0, fractionDigits = 1) =>
  bytes && bytes >= 1048576
    ? `${(bytes / 1048576)?.toFixed(fractionDigits)} Мб`
    : bytes >= 1024
    ? `${(bytes / 1024)?.toFixed(fractionDigits)} Кб`
    : bytes > 0
    ? `${bytes?.toFixed(fractionDigits)} б`
    : "";

const formDataToJSON = (formData) => {
    const dataObject = {};
    formData.forEach((value, key) => dataObject[key] = value);
    return JSON.stringify(dataObject);
}

// function validatePhoneNumber(phoneNumber) {
//     const pattern = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
//     return pattern.test(phoneNumber);
// }
function validatePhoneNumber(phoneNumber) {
    console.log(phoneNumber);
    
    // Проверяет формат: +7 (XXX) XXX XXXX
    const pattern = /^\+7\s\(\d{3}\)\s\d{3}\s\d{4}$/;
    return pattern.test(phoneNumber);
}

function validateEmail(email) {
    const pattern = /\S+@\S+\.\S+/;
    return pattern.test(email);
}

const validateConsultForm = (json, requiredFields) => {
    const data = JSON.parse(json);
    const fieldsError = {};
    const keys = Object.keys(data);

    keys.forEach((key) => {
        if (requiredFields.includes(key)) {
            if (key === "phone" && !validatePhoneNumber(data[key])) {
                fieldsError["phone"] = "Неверно указан номер телефона";
            } else if (key === "email" && !validateEmail(data[key])) {
                fieldsError["email"] = "Неверно указан адрес электронной почты";
            } else if (data[key] === null || data[key] === undefined || data[key] === "") {
                fieldsError[key] = "Не заполнено обязательное поле";
            }
        }
    });

    return fieldsError;
}

function postAjax(url, data) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            resolve(this.responseText);
        };
        xhr.onerror = reject;
        xhr.open('POST', url, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);
    });
}

function displayError(parentNode, msg) {
    const errorBlock = parentNode.querySelector('.modal-wrapper_error-message');                    
    if (errorBlock) { 
        errorBlock.innerHTML = msg;
        errorBlock.classList.add('show'); 
    }
}

function handleSubmitConsultForm(json, requiredFields, modalWrapper) {
    const fieldsError = validateConsultForm(json, requiredFields);
    const footer = modalWrapper.querySelector('.modal-wrapper__footer');

    if (Object.keys(fieldsError).length === 0) {
        postAjax("/api/getConsultation", json)
            .then((result) => {
                modalWrapper.querySelector('.modal-wrapper__content-result').classList.add('show');
            })
            .catch((error) => {
                displayError(footer, "Не удалось отправить заявку на консультацию. Попробуйте повторить позднее.");
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

function initModalFooter(modalWrapper, onSubmit) {
    const footer = modalWrapper.querySelector('.modal-wrapper__footer');
    if (footer) {
        const checkboxPolicy = footer.querySelector('[data-checkbox-policy]');
        const checkboxData = footer.querySelector('[data-checkbox-data]');
        const buttonFormSubmit = footer.querySelector("button");
        const form = modalWrapper.querySelector('form');

        if (buttonFormSubmit && form) {
            const requiredFieldElements = form.querySelectorAll("[required]") || [];
            const requiredFields = [...requiredFieldElements].map(element => element.name);

            buttonFormSubmit.addEventListener("click", (e) => {
                e.preventDefault();
                
                const formData = new FormData(form);
                const json = formDataToJSON(formData);
                onSubmit(json, requiredFields, modalWrapper);
            });
        }

        if (checkboxPolicy && checkboxData && buttonFormSubmit) {
            const updateButtonState = () => {
                buttonFormSubmit.disabled = !(checkboxPolicy.checked && checkboxData.checked);
            };
            updateButtonState();

            checkboxPolicy.addEventListener("change", updateButtonState);
            checkboxData.addEventListener("change", updateButtonState);
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const MODAL_CLASS_NAME = ".modal-wrapper";
    const wrapper = document.querySelector(`[data-consult]`);
    initModalFooter(wrapper, handleSubmitConsultForm);

    const buttonsToggleDetail = document.querySelectorAll("[data-toggle-consult-detail]");
    [...buttonsToggleDetail].forEach((btn) => btn.addEventListener("click", (event) => {
            event.preventDefault();

            const modalContacts = document.querySelectorAll(`${MODAL_CLASS_NAME}__detail`);

            [...modalContacts].forEach((detail) => {
                const contactsClass = detail.classList.length && detail.classList[0] || null;

                detail.classList.toggle(`${contactsClass}_opened`);
            })
        })
    );

    const buttonAttachFile = document.getElementById("btn-consult-attach-file");
    const inputAttachFile = document.getElementById("form-consult__input-file");
    const fileAttach = document.getElementById("form-consult__file-attach");

    if (inputAttachFile) {
        inputAttachFile.addEventListener('change', event => {
            const files = event.target.files;
            const file = files[0];

            if (file) {
                const description = fileAttach.querySelectorAll(".file-item__title-text p");
                const extension = file.name.split('.').pop();

                description[0].textContent = file.name;
                description[1].textContent = `.${extension} ${getFileSize(file.size, 1)}`;

                fileAttach.classList.add("show");
                buttonAttachFile.classList.remove("show");
            }
        });
    }

    const buttonClearFile = document.querySelector("[data-remove-file-item]");

    if (buttonClearFile) {
        buttonClearFile.addEventListener("click", () => {
            inputAttachFile.value = null;
            buttonAttachFile.classList.add("show");
            fileAttach.classList.remove("show");
        });
    }

    const modalConsultContent = document.querySelector(`${MODAL_CLASS_NAME}__content`);

    const ro = new ResizeObserver(entries => {
        const hasVerticalScrollbar = modalConsultContent.scrollHeight > modalConsultContent.clientHeight;
        const searchHeader = document.querySelector(`${MODAL_CLASS_NAME}__header`);
        const searchFooter = document.querySelector(`${MODAL_CLASS_NAME}__footer`);

        const classShadowBottom = "with-bottom-shadow";
        const classShadowTop = "with-top-shadow";

        if (hasVerticalScrollbar && searchFooter && searchHeader) {
            searchHeader.classList.add(classShadowBottom);
            searchFooter.classList.add(classShadowTop);
        } else  {
            searchHeader.classList.remove(classShadowBottom);
            searchFooter.classList.remove(classShadowTop);
        }
    });

    if (modalConsultContent) {
        ro.observe(modalConsultContent);
    }
});
