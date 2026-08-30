$(document).ready(function (event) {
    let fileVideo
    $(".mediaitem").on('click', function(e) {
        e.preventDefault();
        let idVideo = $(this).attr('data-video')
        let modalVideo = $('.fixed-overlay__modal[data-video="'+ idVideo +'"]')
        modalVideo.addClass('videomodal active')
        fileVideo = modalVideo.find('video')[0]
        fileVideo.play()

    });
    $('.modalclose').on('click', function(e) {
        fileVideo.pause()
    });
})