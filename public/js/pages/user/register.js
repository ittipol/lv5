$(document).ready(function(){
	$('form').submit(function(){

		var day = $('#birth_day').val();
		var month = $('#birth_month').val();
		var year = $('#birth_year').val();

		var input = document.createElement("input");
		input.setAttribute("type", "hidden");
		input.setAttribute("name", "birth_date");
		input.setAttribute("value", year+'-'+month+'-'+day);

		this.appendChild(input);

	});
});