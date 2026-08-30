document.addEventListener("DOMContentLoaded", () => {
    const questions = document.querySelectorAll("[data-question-item]");
    [...questions].forEach((question) => {
        const questionTitle = question.querySelector(`.question-item__title`);

        questionTitle.addEventListener("click", (event) => {
            question.classList.toggle(`question-item_opened`);
        });
    });
});
