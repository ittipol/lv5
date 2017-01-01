class AdditionalOption {

  constructor() {
    this.obj = null;
  }

  load(){
    this.bind();
  }

  bind(){

    let _this = this;

    $('.additional-option').on('click',function(){

      _this.closePrevBox();

      let id = _this.generateCode();

      let top = $(this).position().top;
      let left = $(this).position().left;

      let div = document.createElement('div');
      div.setAttribute('class','additional-option-items');
      div.setAttribute('id','additional_option_'+id);
      div.style.top = top+'px';
      div.innerHTML = $(this).find('.additional-option-content').html();

      $(this).parent().append(div);

      $(div).slideDown(220);

      div.style.left = (left - (div.offsetWidth - this.offsetWidth))+'px';

      setTimeout(function(){
        _this.obj = div;
      },500);
    });

    $(document).on('click',function(){
      _this.closePrevBox();
    });

    $(window).resize(function() {
      _this.closePrevBox();
    });
  }

  closePrevBox() {
    if(this.obj != null){
      $(this.obj).fadeOut(220);
      this.obj = null;
    }
  }

  generateCode() {
    let codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    codeAlphabet += "abcdefghijklmnopqrstuvwxyz";
    codeAlphabet += "0123456789";

    let code = '';
    let len = codeAlphabet.length;

    for (let i = 0; i <= 7; i++) {
      code += codeAlphabet[Math.floor(Math.random() * (len - 0) + 0)];
    };

    return code;
  }
}