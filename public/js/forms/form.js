var Form = {}

Form.load = function() {
	Form.init();
}

Form.init = function() {
	$('form input').keydown(function(event){
	  if(event.keyCode == 13) {
	    event.preventDefault();
	    return false;
	  }
	});
}
