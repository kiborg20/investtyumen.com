document.addEventListener("DOMContentLoaded", () => {
    const DATA_ZOOM_NAME = "data-image-zoom";

    const zoomImages = document.querySelectorAll(`[${DATA_ZOOM_NAME}]`);

    [...zoomImages].forEach((img) => {
        const zoomButton = img.querySelector(`[${DATA_ZOOM_NAME}-button]`);
        const popup = img.querySelector(`[${DATA_ZOOM_NAME}-popup]`);

        if (zoomButton && popup) {
            zoomButton.addEventListener("click", (event) => {
                event.preventDefault();
                popup.classList.add('modal-wrapper_opened');
            });

            const closeZoomButton = img.querySelector(`[${DATA_ZOOM_NAME}-close]`);
            if (closeZoomButton) {
                closeZoomButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    popup.classList.remove('modal-wrapper_opened');
                })
            }
        }
    })
});