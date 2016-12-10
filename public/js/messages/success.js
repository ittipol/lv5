var Success = {

}

Success.load = function() {
  // init
  Success.setPositionCenter();
}

Success.setPositionCenter = function() {

	var headerHeight = $('.header').height();
	var footerHeight = $('.footer').height();

	var documentHeight = $(document).height();
	var h = (documentHeight - (headerHeight + footerHeight)) / 2;

	$('#success').css('marginTop',h);
	$('#success').css('marginBottom',h);

}

$(document).ready(function(){
	Success.load();
});