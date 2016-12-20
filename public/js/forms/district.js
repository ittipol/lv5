var District = {
  subDistrictId: null
}

District.load = function(subDistrictId){
  District.init();
  District.bind();

  if (typeof subDistrictId != 'undefined') {
    District.subDistrictId = subDistrictId;
  }
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

  var CSRF_TOKEN = $('input[name="_token"]').val();        

	var request = $.ajax({
    url: "/api/get_sub_district/"+districtId,
    type: "get",
    // data: {_token:CSRF_TOKEN},
    dataType:'json'
  });

  // Callback handler that will be called on success
  request.done(function (response, textStatus, jqXHR){
    $('#sub_district').empty();
    $.each(response, function(key,value) {
      
      var option = $("<option></option>");

      if(key == District.subDistrictId){
        option.prop('selected',true);
      }

      $('#sub_district').append(option.attr("value", key).text(value));

    });

    District.subDistrictId = null;
    
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