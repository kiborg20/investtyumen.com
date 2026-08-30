var cur_filter = "Все";
var CURRENT_PAGE = 1;
var TOTAL_PAGES = 1;
var PAGE_LIMIT = 9;

function getPaginationRoot() {
    return document.getElementById("pagination_news_list");
}

function getPaginationItems(current, total, siblingCount = 2, boundaryCount = 2) {
    if (total <= 1) {
        return [];
    }

    const maxVisible = boundaryCount * 2 + siblingCount * 2 + 3;
    if (total <= maxVisible) {
        return Array.from({ length: total }, (_, index) => index + 1);
    }

    const pages = new Set();

    for (let i = 1; i <= boundaryCount; i++) {
        pages.add(i);
    }

    for (let i = total - boundaryCount + 1; i <= total; i++) {
        pages.add(i);
    }

    for (let i = current - siblingCount; i <= current + siblingCount; i++) {
        if (i >= 1 && i <= total) {
            pages.add(i);
        }
    }

    const sorted = [...pages].sort((a, b) => a - b);
    const result = [];
    let prev = 0;

    sorted.forEach((page) => {
        if (prev) {
            if (page - prev === 2) {
                result.push(prev + 1);
            } else if (page - prev > 2) {
                result.push("...");
            }
        }

        result.push(page);
        prev = page;
    });

    return result;
}

function updateNavButtons(current) {
    const pagination = getPaginationRoot();
    if (!pagination) {
        return;
    }

    const prevBtn = pagination.querySelector(".pagination__button_prev");
    const nextBtn = pagination.querySelector(".pagination__button_next");
    if (!prevBtn || !nextBtn) {
        return;
    }

    prevBtn.parentElement.style.visibility = current <= 1 ? "hidden" : "visible";
    nextBtn.parentElement.style.visibility = current >= TOTAL_PAGES ? "hidden" : "visible";
}

function renderPagination(current) {
    const pagination = getPaginationRoot();
    if (!pagination) {
        return;
    }

    const pageLink = document.getElementById("links");
    if (!pageLink) {
        return;
    }

    const section = pagination.closest(".seaction");
    CURRENT_PAGE = current;
    PAGE = current;

    if (TOTAL_PAGES <= 1) {
        if (section) {
            section.style.visibility = "hidden";
        }
        pageLink.innerHTML = "";
        return;
    }

    if (section) {
        section.style.visibility = "visible";
    }

    pageLink.innerHTML = "";

    getPaginationItems(current, TOTAL_PAGES).forEach((item) => {
        if (item === "...") {
            const dots = document.createElement("span");
            dots.className = "pagination__ellipsis";
            dots.textContent = "...";
            pageLink.appendChild(dots);
            return;
        }

        const link = document.createElement("a");
        link.className = "pagination__link";
        link.href = "#";
        link.dataset.page = String(item);
        link.textContent = String(item);

        if (item === current) {
            link.classList.add("pagination__link_current");
        }

        pageLink.appendChild(link);
    });

    updateNavButtons(current);
}

function updatePageCount(count) {
    const pagination = getPaginationRoot();
    if (!pagination) {
        return;
    }

    const limit = Number(pagination.dataset.limit) || PAGE_LIMIT;
    TOTAL_PAGES = Math.max(1, Math.ceil(Number(count) / limit));
    pagination.dataset.pages = String(TOTAL_PAGES);
    renderPagination(1);
}

function onFiltersNewsClick(element) {
    PAGE = 1;
    CURRENT_PAGE = 1;
    const value = element.dataset.filterNewsType;
    cur_filter = value;

    if (value === "Все") {
        getDataByFilters();
    } else {
        getDataByFilters({ type: value });
    }

    if (typeof TOTAL_COUNT !== "undefined") {
        updatePageCount(TOTAL_COUNT);
    } else {
        renderPagination(1);
    }
}

function onNewsPageChange(p) {
    const page = Number(p);
    if (!page || page < 1 || page > TOTAL_PAGES || page === CURRENT_PAGE) {
        return;
    }

    renderPagination(page);

    if (cur_filter === "Все") {
        getDataByFilters();
    } else {
        getDataByFilters({ type: cur_filter });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const pagination = getPaginationRoot();
    if (!pagination) {
        return;
    }

    TOTAL_PAGES = Number(pagination.dataset.pages) || 1;
    PAGE_LIMIT = Number(pagination.dataset.limit) || 9;
    CURRENT_PAGE = Number(pagination.dataset.page) || 1;
    PAGE = CURRENT_PAGE;

    renderPagination(CURRENT_PAGE);

    pagination.addEventListener("click", (event) => {
        const target = event.target.closest("a");
        if (!target || !pagination.contains(target)) {
            return;
        }

        event.preventDefault();

        if (target.classList.contains("pagination__button_prev")) {
            onNewsPageChange(CURRENT_PAGE - 1);
            return;
        }

        if (target.classList.contains("pagination__button_next")) {
            onNewsPageChange(CURRENT_PAGE + 1);
            return;
        }

        if (target.classList.contains("pagination__link") && target.dataset.page) {
            onNewsPageChange(Number(target.dataset.page));
        }
    });
});
