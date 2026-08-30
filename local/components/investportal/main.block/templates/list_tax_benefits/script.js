var last_selected;

function createFinanceCard(item)
{
    const card = document.createElement("div");
    card.classList.add("card__item", "card__item_border", "card__item_between", "card__item-s")
    const cardContent = document.createElement("div");
    cardContent.classList.add("support-card___content");
    const cardTag = document.createElement("div");
    cardTag.classList.add("support-card__tags");
    const tag = document.createElement("div");
    tag.classList.add("support-card__tag");
    tag.innerHTML = item.types[0].PROPERTY_ENUM_VALUE;

    const headLine = document.createElement("h4");
    headLine.classList.add("headline", "headline_size-h4");
    headLine.innerHTML = item.NAME;

    const description = document.createElement("div");
    description.classList.add("description","description_size-p1","description_padding-none");
    description.innerHTML = item.PREVIEW_TEXT;

    cardTag.appendChild(tag);
    cardContent.appendChild(cardTag);
    cardContent.appendChild(headLine);
    cardContent.appendChild(description);

    //BUTTONS
    const buttonsBlock = document.createElement("div");
    buttonsBlock.classList.add("support-card__buttons");
    const href = document.createElement("a");
    href.classList.add("button","button_size-m","button_theme-blue");
    href.href = "/" + item.CODE;
    href.innerHTML = "Подробнее";

    buttonsBlock.appendChild(href);
    if (item.href) {
        const href2 = document.createElement("a");
        href2.classList.add("button","button_size-m","button_theme-gray");
        href2.href = item.href.PROPERTY_VALUE;
        href2.innerHTML = item.hrefname.PROPERTY_VALUE;
        buttonsBlock.appendChild(href2);
    }


    cardContent.appendChild(buttonsBlock);
    card.appendChild(cardContent);

    return card;
}

function getListFinanceSupport(filters) {
    const docList = document.querySelector('.support-cards');
    docList.innerHTML = "";

    BX.ajax.runComponentAction('investportal:main.block', 'getByFilter', {
        mode: 'class',
        data: {
            aRequest: {
                IBLOCK: 'nalogovyelgoty',
                TYPE: 'pforinvestor',
                LIMIT: 10,
                FILTERS: filters,
            }
        }
    }).then((response) => {
        if (response?.data?.response?.data) {
            const data = JSON.parse(response?.data?.response?.data);
            if (Array.isArray(data.ITEMS)) {
                data.ITEMS.forEach((item) => {
                    const node = createFinanceCard(item);
                    docList.appendChild(node);
                });
            }
        }
    }).catch((error) => {
        console.log(error?.data);
    });
}

function onFiltersNewsClick(element) {
    if (last_selected) {
        last_selected.classList.remove("button_theme-blue");
        last_selected.classList.add("button_theme-transparent");
    } else {
        let a = document.querySelector(".f");
        a.classList.remove("button_theme-blue");
        a.classList.add("button_theme-transparent");
    }


    element.classList.add("button_theme-blue");
    element.classList.remove("button_theme-transparent");
    last_selected = element;

    getListFinanceSupport({'types': element.dataset.item});
}