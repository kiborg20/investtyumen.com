function getSubjectCooperationDataByFilters(filters) {
    const docList = document.querySelector('.cooperation-subject-list');
    docList.innerHTML = "";

    BX.ajax.runComponentAction('investportal:main.block', 'getByFilter', {
        mode: 'class',
        data: {
            aRequest: {
                IBLOCK: 'cooperationproposal',
                TYPE: 'pforinvestor',
                FILTERS: filters,
            }
        }
    }).then((response) => {
        if (response?.data?.response?.data) {
            const data = JSON.parse(response?.data?.response?.data);
            if (Array.isArray(data.ITEMS)) {
                data.ITEMS.forEach((item) => {
                    const node = createDocCardItem(item);
                    docList.appendChild(node);
                });
            }
        }
    }).catch((error) => {
        console.log(error?.data);
    });
}

var cur_filter = document.querySelector('.f2').children[0];

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
    link.setAttribute("href", data.file ? data.file["PROPERTY_VALUE"] + "/" || "#" : "#");
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

function onFiltersSubjectCooperationClick(element)
{
    cur_filter.className = "button button_theme-transparent button_size-s";
    cur_filter = element;

    element.className = "button button_theme-blue button_size-s";

    const value = element.dataset.filterCooperationSubject;
    getSubjectCooperationDataByFilters({'subjects': value});
}