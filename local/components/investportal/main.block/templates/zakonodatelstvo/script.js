const months = [
    "Январь",
    "Февраль",
    "Март",
    "Апрель",
    "Май",
    "Июнь",
    "Июль",
    "Август",
    "Сентябрь",
    "Октябрь",
    "Ноябрь",
    "Декабрь"
  ];

const weekDays = ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"];

const DEFAULT_FILTERS_DATA = {
    "type": [],
    "document_type": "",
    "document_publisher": "",
    "number": "",
    "date": "",
};

var CUR_PAGE = 1;

function updatePageCount(count)
{
    const limit = 10;
    const pagination = document.getElementById('pagination_news_list');


    if (pagination) {
        const page_link = document.getElementById('links');
        pagination.querySelectorAll('.pagination__link').forEach(e => e.remove());
        let pages = Math.ceil(count / limit);
        if (pages === 1) {
            document.querySelector(".section-pagination").classList.remove("show");
            return;
        }

        document.querySelector(".section-pagination").classList.add("show");
        for (let i = 1; i <= pages; i++) {
            const card = document.createElement("a");
            card.classList.add('pagination__link');
            if (i === 1) {
                card.classList.add('pagination__link_current');
            }

            card.innerHTML = i;
            page_link.appendChild(card);
        }
    }
}

function onNewsPageChange(p) {
    const pagination = document.getElementById('pagination_news_list');

    if (pagination) {
        const prevBtn = pagination.querySelector('.pagination__button_prev');
        const nextBtn = pagination.querySelector('.pagination__button_next');

        const prevBtnParent = prevBtn.parentElement;
        const nextBtnParent = nextBtn.parentElement;

        const pages = pagination.querySelectorAll('.pagination__link');

        if (p === pages.length) {
            nextBtnParent.style.visibility = "hidden";
            prevBtnParent.style.visibility = "visible";
        } else {
            nextBtnParent.style.visibility = "visible";
            if (p === 1) {
                prevBtnParent.style.visibility = "hidden";
            } else {
                prevBtnParent.style.visibility = "visible";
            }
        }

        pages.forEach((page) => {
            if (Number(page.innerHTML) === p) {
                page.classList.add('pagination__link_current');
            } else {
                page.classList.remove('pagination__link_current');
            }
        })
        updateData();
    }
}

function updateData()
{

    const dateinput = document.getElementById("form-search-document__date");
    var filtersData = DEFAULT_FILTERS_DATA;
    const formSearch = document.getElementById('search-documents-form');
    const searchTerm = formSearch.search.value;

    const filters = {
        ...filtersData,
        "document_publisher": formSearch.documentPublisher.value === "Все" ? "": formSearch.documentPublisher.value,
        "document_type": formSearch.documentType.value === "Все" ? "" : formSearch.documentType.value,
        "number": formSearch.number.value === "Все" ? "" : formSearch.number.value,
        "date": dateinput.value,
    }

    getDocumentsDataByFilters(filters, searchTerm, CUR_PAGE);
}

function showNotFoundResult(search) {
    const notFoundElement = document.querySelector(".section-not-found");
    const notFoundElementMessage = notFoundElement.getElementsByClassName('headline')[0];
    notFoundElementMessage.innerHTML = search ? `Мы ничего не нашли по запросу «${search}»` : 'Мы ничего не нашли по вашему запросу';
    notFoundElement.classList.add("show");
    document.querySelector(".section-documents").classList.remove("show");
    if (document.querySelector('.section-pagination') !== null) {
        document.querySelector(".section-pagination").classList.remove("show");
    }
}

function createDocCardItem(data) {
    const card = document.createElement("div");
    card.setAttribute("class", "link-cards__item column-2");
    const innerCard = document.createElement("div");
    innerCard.setAttribute("class", "link-cards__link link-cards__link-column");

    //headline
    const headline = document.createElement("div");
    headline.setAttribute("class", "link-cards__headline");

    const name = document.createElement("p");
    name.setAttribute("class", "description strong description_size-p1 description_padding-none");
    name.innerText = data["NAME"];

    const link = document.createElement("a");
    link.setAttribute("class", "button button_theme-white button_size-s");
    link.setAttribute("href", data.file ? data.file["PROPERTY_VALUE"] || "#" : "#");
    link.setAttribute("target", "_blank");

    const linkIcon = document.createElement("div");
    linkIcon.setAttribute("class", "button__icon");
    linkIcon.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.7501 13.1893L15.9394 10C16.2323 9.70712 16.7071 9.70712 17 10C17.2929 10.2929 17.2929 10.7678 17 11.0607L12.5304 15.5303C12.3897 15.671 12.199 15.75 12.0001 15.75C11.8011 15.75 11.6104 15.671 11.4697 15.5303L7.00006 11.0606C6.70717 10.7678 6.70717 10.2929 7.00006 9.99998C7.29296 9.70708 7.76783 9.70708 8.06072 9.99998L11.2501 13.1893V2.75C11.2501 2.72411 11.2514 2.69853 11.2539 2.67332C11.2923 2.29513 11.6117 2 12.0001 2C12.4143 2 12.7501 2.33579 12.7501 2.75V13.1893Z" fill="#252830"/><path d="M4.75 14.7503C4.75 14.336 4.41421 14.0003 4 14.0003C3.58578 14.0003 3.25 14.336 3.25 14.7503V19.0002C3.25 19.9667 4.0335 20.7502 5 20.7502H19C19.9665 20.7502 20.75 19.9667 20.75 19.0002V14.7503C20.75 14.336 20.4142 14.0003 20 14.0003C19.5858 14.0003 19.25 14.336 19.25 14.7503V19.0002C19.25 19.1383 19.138 19.2502 19 19.2502H5C4.86193 19.2502 4.75 19.1383 4.75 19.0002V14.7503Z" fill="#252830"/></svg>';
    link.appendChild(linkIcon);

    headline.appendChild(name);
    headline.appendChild(link);

    //document-info
    const docInfo = document.createElement("div");
    docInfo.setAttribute("class", "document-info description_padding-top-s description_c-black-60 description_size-p3");
    if (data["DATE_CREATE"] && typeof data["DATE_CREATE"] === "string") {
        const docDate = document.createElement("span");
        docDate.innerText = data["DATE_CREATE"];
        docInfo.appendChild(docDate);
    }

    if (data.number && data.number["PROPERTY_VALUE"]) {
        const docNumber = document.createElement("span");
        docNumber.innerText = `№${data.number["PROPERTY_VALUE"]}`;
        docInfo.appendChild(docNumber);
    }

    if (data["document_type"] && data["document_type"]["PROPERTY_ENUM_VALUE"]) {
        const docType = document.createElement("span");
        docType.innerText = data["document_type"]["PROPERTY_ENUM_VALUE"];
        docInfo.appendChild(docType);
    }

    if (data["document_publisher"] && data["document_publisher"]["PROPERTY_ENUM_VALUE"]) {
        const docAuthor = document.createElement("span");
        docAuthor.innerText = data["document_publisher"]["PROPERTY_ENUM_VALUE"];
        docInfo.appendChild(docAuthor);
    }

    innerCard.appendChild(headline);
    innerCard.appendChild(docInfo);
    card.appendChild(innerCard);

    return card;
}

function getDocumentsDataByFilters(filters, search, page, update = false) {
    const notFoundElement = document.querySelector(".section-not-found");
    notFoundElement.classList.remove("show");

    BX.ajax.runComponentAction('investportal:main.block', 'getByFilter', {
        mode: 'class',
        data: {
            aRequest: {
                IBLOCK: 'zakonodatelnaya-baza',
                TYPE: 'content',
                FILTERS: filters,
                SEARCH: search,
                LIMIT: 10,
                PAGE: page
            }
        }
    }).then((response) => {
        if (response?.data?.response?.data) {
            document.querySelector(".section-documents").classList.add("show");

            if (document.querySelector('.section-pagination') !== null) {
                document.querySelector(".section-pagination").classList.add("show");
            }

            const docList = document.querySelector('.document-list');
            docList.innerHTML = "";

            const data = JSON.parse(response?.data?.response?.data);
            if (Array.isArray(data.ITEMS)) {
                if (update) {
                    updatePageCount(data.COUNT);
                }
                data.ITEMS.forEach((item) => {
                    const node = createDocCardItem(item);
                    docList.appendChild(node);
                });
            }
        } else {
            showNotFoundResult(search);
        }
    }).catch((error) => {
        console.log(error?.data);
        showNotFoundResult(search);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    var filtersData = DEFAULT_FILTERS_DATA;

    const head = document.getElementsByTagName("head")[0];
    const link = document.createElement("link");

    link.rel = "stylesheet";
    link.type = "text/css";
    link.href = "https://cdn.jsdelivr.net/npm/js-datepicker@5.18.2/dist/datepicker.min.css";
    link.media = "all";
  
    head.appendChild(link);

    /** TOGGLE EXTRA SEARCH */

    const rowExtraSearch = document.querySelector('.documents-extra-search-row');
    const buttonsToggleExtraSearch = document.querySelectorAll(`[data-btn-extra-search-params]`);
    [...buttonsToggleExtraSearch].forEach((btn) => {
        btn.addEventListener('click', () => {
            rowExtraSearch.classList.toggle("show");
        })
    });

    // TAGS
    const tagButtons = document.querySelectorAll('[data-search-tag]');
    [...tagButtons].forEach((tag) => {
        tag.addEventListener('click', (e) => {
            const value = e.target.innerText;
            if (filtersData.type.includes(value)) {
                tag.classList.remove('selected');
                const copyTags = filtersData.type.filter(t => t !== value);
                filtersData.type = copyTags;
            } else {
                tag.classList.add('selected');
                filtersData.type.push(value);
            }
        });
    });

    const formSearch = document.getElementById('search-documents-form');
    const btnSubmit = formSearch.querySelector('[data-search-input-submit]');

    // FORM SUBMIT
    btnSubmit?.addEventListener("click", (e) => {
        e.preventDefault();

        const searchTerm = formSearch.search.value;

        const filters = {
            ...filtersData,
            "document_publisher": formSearch.documentPublisher.value === "Все" ? "": formSearch.documentPublisher.value,
            "document_type": formSearch.documentType.value === "Все" ? "" : formSearch.documentType.value,
            "number": formSearch.number.value === "Все" ? "" : formSearch.number.value,
            "date": dateinput.value,
        }

        getDocumentsDataByFilters(filters, searchTerm, 1, true);
    });

    // FORM RESET
    const buttonsResetForm = document.querySelectorAll('[data-btn-search-clear-params]');
    [...buttonsResetForm].forEach((btn) => {
        btn.addEventListener('click', () => {
            [...tagButtons].forEach((tag) => {tag.classList.remove("selected")});
            filtersData = DEFAULT_FILTERS_DATA;
            formSearch?.reset();
        })
    });

    /** SEARCH ROW */
    const clearSearchInputButton = formSearch.querySelector('[data-search-input-clear]');
    clearSearchInputButton.addEventListener("click", () => {
        formSearch.search.value = "";
    })

    /** DATE PICKER */
    const INPUT_NAME = "form-search-document__date";
    const dateinput = document.getElementById(INPUT_NAME);

    const btnApply = document.createElement("button");
    btnApply.classList.add("button", "button_size-m", "button_theme-blue");
    btnApply.textContent = "Применить";
    btnApply.type = "button";

    const btnClear = document.createElement("button");
    btnClear.classList.add("button", "button_size-m", "button_theme-gray");
    btnClear.textContent = "Сбросить";
    btnClear.type = "button";
    btnClear.addEventListener("click", () => {
        dateinput.value = null;
        filtersData.date = "";
    });

    const buttonPanel = document.createElement("div");
    buttonPanel.classList.add("buttons-panel");

    buttonPanel.appendChild(btnClear);
    buttonPanel.appendChild(btnApply);
    
    datepicker(dateinput, {
        position: "br",
        startDay: 1,
        showAllDates: true,
        disableMobile: true,
        maxDate: new Date(),
        minDate: new Date(1900, 0, 1),
        customMonths: months,
        customOverlayMonths: months,
        customDays: weekDays,
        formatter: (input, date, instance) => {
            const yyyy = date.getFullYear();
            let mm = date.getMonth() + 1;
            let dd = date.getDate();
            const formattedToday = `${dd < 10 ? `0${dd}` : dd}.${mm < 10 ? `0${mm}` : mm}.${yyyy}`;
            dateinput.value = formattedToday;
          },
        overlayPlaceholder: "Год",
        overlayButton: "Применить",
        onSelect: instance => {
            instance.show();
          },
        onShow: instance => {
            btnApply.addEventListener("click", (e) => {
                e.stopPropagation();
                instance.hide();
            });

            const calendarDiv = instance.calendarContainer;
            calendarDiv.appendChild(buttonPanel);
          },
      });

    const pagination = document.getElementById('pagination_news_list');
    if (pagination) {
        const prevBtn = pagination.querySelector('.pagination__button_prev');
        const nextBtn = pagination.querySelector('.pagination__button_next');

        const pages = pagination.querySelectorAll('.pagination__link');
        pages.forEach((page) => {
            page.addEventListener("click", (event) => {
                event.preventDefault();
                CUR_PAGE = Number(page.innerHTML);
                onNewsPageChange(CUR_PAGE);
            });
        });

        prevBtn.addEventListener("click", (event) => {
            event.preventDefault();
            if (CUR_PAGE > 1) {
                CUR_PAGE--;
                onNewsPageChange(CUR_PAGE);
            }
        });

        nextBtn.addEventListener("click", (event) => {
            event.preventDefault();
            if (CUR_PAGE < pages.length) {
                CUR_PAGE++;
                onNewsPageChange(CUR_PAGE);
            }
        });
    }
});
