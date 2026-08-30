function removeElement(arr, sElement)
{
	var tmp = new Array();
	for (var i = 0; i<arr.length; i++) if (arr[i] != sElement) tmp[tmp.length] = arr[i];
	arr=null;
	arr=new Array();
	for (var i = 0; i<tmp.length; i++) arr[i] = tmp[i];
	tmp = null;
	return arr;
}

function SectionClick(id)
{
	var div = document.getElementById('user_div_'+id);
	if (div.className == "profile-block-hidden")
	{
		opened_sections[opened_sections.length]=id;
	}
	else
	{
		opened_sections = removeElement(opened_sections, id);
	}

	document.cookie = cookie_prefix + "_user_profile_open=" + opened_sections.join(",") + "; expires=Thu, 31 Dec 2020 23:59:59 GMT; path=/;";
	div.className = div.className == 'profile-block-hidden' ? 'profile-block-shown' : 'profile-block-hidden';
}
$(document).ready(function () {
	$("#file_personal").change(function(){
		readURL(this)
		$('#PERSONAL_PHOTO_del').prop('checked', false);
		$('.personal-view-wrap-img-del').show(500)
	});
	$('.personal-view-wrap-img-del').on('click' , function () {
		removePhoto()
	})
})
function removePhoto() {
	$('.personal-view-wrap-img img').remove()
	$('.personal-view-wrap-img span').show(500)
	$('.personal-view-wrap-img-del').hide(500)
	$('#PERSONAL_PHOTO_del').prop('checked', true);
	$('#file_personal').val('')
}

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			if ($('.personal-view-wrap-img img').length > 0) {
				$('.personal-view-wrap-img img').attr('src', e.target.result);
			} else {
				$('.personal-view-wrap-img span').hide()
				$('.personal-view-wrap-img').append('<img src="'+ e.target.result+ '">')
			}
		}

		reader.readAsDataURL(input.files[0]);
	}
}

