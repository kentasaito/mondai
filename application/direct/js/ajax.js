function preloadAudio()
{
	$('audio').each(function(index, element){
		element.volume = 0;
		element.play();
	});
}

function playAudio(id)
{
	$('#audio_' + id)[0].volume = 1;
	$('#audio_' + id)[0].currentTime = 0;
	$('#audio_' + id)[0].play();
}

function onAClick()
{
	ajax(this.href, null);
	return false;
}

function onFormSubmit()
{
	ajax(this.action, $(this).serialize());
	return false;
}

function useAjax(selector)
{
	if ( ! config_use_ajax)
	{
		return;
	}
	$(selector + ' a[target!=_blank]').click(onAClick);
	$(selector + ' form').submit(onFormSubmit);
}

function ajax(url, data)
{
	$.ajax({
		type: 'post',
		url: url,
		data: data,
		success: function(contents){
			$('#contents').html(contents);
			useAjax('#contents');
		},
		error: function(contents){
			alert('Ajax error:\n' + this.url);
		},
	});
}

$(function(){
	useAjax('body');
});
