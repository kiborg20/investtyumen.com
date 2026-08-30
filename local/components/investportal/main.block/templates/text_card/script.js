document.addEventListener("DOMContentLoaded", () => {
  const linkToButtons = document.querySelectorAll("[data-scroll-to]");

  if (linkToButtons && linkToButtons.length > 0) {
    linkToButtons.forEach(button => {
      button.addEventListener("click", (event) => {
        event.preventDefault();

        const current = event.currentTarget;

        const attr = current.getAttribute("href");

        if (attr) {
          const scrollSection = document.querySelector(attr);

          if (scrollSection) {
            scrollSection.scrollIntoView({ behavior: "smooth", block: "center" });

            linkToButtons.forEach(item => {
              if (item.classList.contains("active")) {
                item.classList.remove("active");
              }
            });

            current.classList.add("active");
          }
        }
      });
    });
  }

  const cardSliders = document.querySelectorAll("[data-card-slider]");
  [...cardSliders].forEach((slider) => {
    let sliderActiveItem = 0;

    const cards = slider.querySelectorAll('[data-card-slider-item]');
    const slides = slider.querySelectorAll('[data-card-slider-slide]');

    cards[sliderActiveItem].classList.add('active');
    slides[sliderActiveItem].classList.add('active');

    const cardsCount = cards?.length || 0;
    const cardLastNumber = cardsCount === 0 ? 0 : cardsCount - 1;
    const cardSliderButtons = document.querySelectorAll("[data-card-slider-button]");

    cardSliderButtons.forEach(button => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        cards.forEach(c => c.classList.remove('active'));
        slides.forEach(s => s.classList.remove('active'));

        if (button.classList.contains('card-slider__nav_prev')) {
          sliderActiveItem = sliderActiveItem === 0 ? cardLastNumber : sliderActiveItem - 1;
        } else {
          sliderActiveItem = sliderActiveItem >= cardLastNumber ? 0 : sliderActiveItem + 1;
        }
        const activeItem = cards[sliderActiveItem];
        activeItem.classList.add('active');
        slides[sliderActiveItem].classList.add('active');
      });      
    });

    const photoContainers = slider.querySelectorAll('.person-image');
    [...photoContainers].forEach((photo) => {
      photo.addEventListener("click", (event) => {
        event.preventDefault();
        cards.forEach(c => c.classList.remove('active'));
        slides.forEach(s => s.classList.remove('active'));
        sliderActiveItem = sliderActiveItem >= cardLastNumber ? 0 : sliderActiveItem + 1;
        const activeItem = cards[sliderActiveItem];
        activeItem.classList.add('active');
        slides[sliderActiveItem].classList.add('active');
      })
    })
  });
});