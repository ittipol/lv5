class Form {
	constructor() {}

	load() {
		this.init();
	}

	init() {
	  $('form input').keydown(function(event){
  	  if(event.keyCode == 13) {
  	    event.preventDefault()
  	    return false;
  	  }
  	});
	}
}