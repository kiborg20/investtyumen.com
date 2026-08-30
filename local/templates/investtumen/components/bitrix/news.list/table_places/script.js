$(document).ready(function(){
    $('.plase_reserved').click(function(e){
        e.preventDefault();
        var place = $(this).data('place');
        UIkit.switcher('.tabs_block').show(1);
        $('#place').val(place);
    });
});