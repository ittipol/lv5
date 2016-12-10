var District = {}

District.load = function(){
  District.init();
  District.bind();
}

District.init = function(){
  var districtId = $('#district').val();
  District.getSubDistrict(districtId);
} 

District.bind = function(){
  $('#district').on('change',function(){
  	District.getSubDistrict($(this).val());
  });
} 

District.getSubDistrict = function(districtId){

	var request = $.ajax({
    url: "/api/get_sub_district/"+districtId,
    type: "get",
    // data: serializedData
  });

  // Callback handler that will be called on success
  request.done(function (response, textStatus, jqXHR){
    $('#sub_district').empty();
    $.each(response, function(key,value) {
      $('#sub_district').append($("<option></option>")
         .attr("value", key).text(value));
    });
  });

  // Callback handler that will be called on failure
  request.fail(function (jqXHR, textStatus, errorThrown){
    // Log the error to the console
    console.error(
        "The following error occurred: "+
        textStatus, errorThrown
    );
  });

  // Callback handler that will be called regardless
  // if the request failed or succeeded
  request.always(function () {});
}