document.addEventListener("DOMContentLoaded", () => {
    const DATA_ZOOM_NAME = "data-video-zoom";

    const zoomImages = document.querySelectorAll(`[${DATA_ZOOM_NAME}]`);

    [...zoomImages].forEach((img) => {
        const zoomButton = img.querySelector(`[${DATA_ZOOM_NAME}-button]`);
        const popup = img.querySelector(`[${DATA_ZOOM_NAME}-popup]`);
        const videoElement = img.querySelector('iframe');        
        const src = videoElement.src;

        if (!src.includes('/embed/')) {            
            let newSrc = src;
            if (src.includes('youtube.com')) newSrc = src.replace('youtube.com/', 'youtube.com/embed/');
            else if (src.includes('youtu.be')) newSrc = src.replace('/youtu.be/', '/www.youtube.com/embed/');
            videoElement.setAttribute('src', newSrc);
        }

        if (zoomButton && popup) {
            zoomButton.addEventListener("click", async (event) => {
                event.preventDefault();
                popup.classList.add('modal-wrapper_opened');
            });

            const closeZoomButton = img.querySelector(`[${DATA_ZOOM_NAME}-close]`);
            if (closeZoomButton) {
                closeZoomButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    popup.classList.remove('modal-wrapper_opened');

                    if (videoElement) {
                        //stop video when closed          
                        const videoSource = videoElement.src;              
                        videoElement.setAttribute('src', videoSource);
                    }
                })
            }
        }
    })
});