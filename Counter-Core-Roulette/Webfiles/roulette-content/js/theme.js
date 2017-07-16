var theme = $.cookie('theme');
if (theme == 'on') {
	document.getElementById("style").href = "/template/css/black.css";
	$('#logo').removeClass('logo');
	$('#logo').addClass('logod');
}else{
	document.getElementById("style").href = "";
}
$(document).on('click', '#dark', function(e) {
	e.preventDefault();
	document.getElementById("style").href = "/template/css/black.css";
	$('#logo').removeClass('logo');
	$('#logo').addClass('logod');
	theme = 'on';
	$.cookie('theme', 'on', { expires: 365 });
});

$(document).on('click', '#light', function(e) {
	e.preventDefault();
	document.getElementById("style").href = "";
	$('#logo').removeClass('logod');
	$('#logo').addClass('logo');
	theme = 'off';
	$.cookie('theme', 'off', { expires: 365 });
});
