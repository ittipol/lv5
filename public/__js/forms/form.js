class Form {
	constructor() {}

	load() {
		this.init();
		this.bind();
	}

	init() {
	  $('form input').keydown(function(event){
  	  if(event.keyCode == 13) {
  	    event.preventDefault()
  	    return false;
  	  }
  	});
	}

	bind() {
		$('#main_form').on('submit',function(){
			$('input[type="submit"]').prop('disabled','disabled').addClass('disabled');
		});
	}
}