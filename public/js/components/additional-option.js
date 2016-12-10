var AdditionalOption = {
  _this: null
}

AdditionalOption.load = function(){
  AdditionalOption.bind();
}

AdditionalOption.bind = function(){
  $('.additional-option').on('click',function(){
    var _this = this;
    $(this).find('.additional-option-items').slideDown(220);
    setTimeout(function(){
      AdditionalOption._this = _this;
    },500);
  });

  $(document).on('click','body',function(){
    if(AdditionalOption._this != null){
      $(AdditionalOption._this).find('.additional-option-items').fadeOut(220);
      AdditionalOption._this = null;
    }
  });
}