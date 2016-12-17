var Form = {}

Form.load = function() {
	Form.init();
	// Form.bind();
}

Form.init = function() {
	$('form input').keydown(function(event){
	  if(event.keyCode == 13) {
	    event.preventDefault();
	    return false;
	  }
	});
}

Form.bind = function() {
}