function createCountryCardItem(data) {
    const card = document.createElement("div");
    card.setAttribute("class", "link-cards__item");

    const innerCard = document.createElement("a");
    innerCard.setAttribute("class", "link-cards__link");
    innerCard.setAttribute("href", data['CODE'] + '/' || '/');

    const name = document.createElement("p");
    name.setAttribute("class", "description strong description_size-p1 description_padding-none");
    name.innerText = data["NAME"];

    innerCard.appendChild(name);

    if (data['icon'] && data['icon']['PROPERTY_VALUE']) {
        innerCard.innerHTML += data['icon']['PROPERTY_VALUE'];
    }

    card.appendChild(innerCard);
    return card;
}

var current_filter = document.querySelector('.filter-panel').children[0];

function getCountryDataByFilters(filters) {
    const docList = document.querySelector('.international_cards');
    docList.innerHTML = "";

    BX.ajax.runComponentAction('investportal:main.block', 'getByFilter', {
        mode: 'class',
        data: {
            aRequest: {
                IBLOCK: 'internationalcooperation',
                TYPE: 'pforinvestor',
                FILTERS: filters,
            }
        }
    }).then((response) => {
        if (response?.data?.response?.data) {
            const data = JSON.parse(response?.data?.response?.data);
            if (Array.isArray(data.ITEMS)) {
                data.ITEMS.forEach((item) => {
                    const node = createCountryCardItem(item);
                    docList.appendChild(node);
                });
            }
        }
    }).catch((error) => {
        console.log(error?.data);
    });
}

function onFiltersCountryClick(element) {
    current_filter.className = "button button_theme-transparent button_size-s";
    current_filter = element;

    element.className = "button button_theme-blue button_size-s";

    const value = element.dataset.filterCountry;
    getCountryDataByFilters({'partworld': value});
}