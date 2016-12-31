<div class="wrapper">
  @include('layouts.blackbox.components.action-bar')
  @include('layouts.blackbox.components.main-nav')
  @include('layouts.blackbox.components.main-panel')
</div>

<script type="text/javascript">

  class Blackbox {

    constructor() {
      this.mainNavWidth = 280;
    }

    load(){
      this.bind();
      this.setLayout();

      $('.wrapper').fadeIn(1);
    }

    bind() {
      $(window).resize(function() {

        let w = window.innerWidth;
        let h = window.innerHeight;

        $('.main-navigation').css({
          width: this.mainNavWidth,
          height: h
        });

        $('.main-panel').css({
          width: w,
          height: h
        });

        if(w > 992) {
          if($('#main_nav_trigger').is(':checked')) {
            $('#main_nav_trigger').trigger('click');
          }
        }

      });

      $('#main_nav_trigger').on('click',function(){
        if($(this).is(':checked')) {
          $('.main-navigation').addClass('is-main-nav-open');
          $('.main-panel').addClass('is-main-nav-open');
          $('.action-bar').addClass('is-main-nav-open');
          $('.main-panel-overlay').addClass('isvisible');
        }else{
          $('.main-navigation').removeClass('is-main-nav-open');
          $('.main-panel').removeClass('is-main-nav-open');
          $('.action-bar').removeClass('is-main-nav-open');
          $('.main-panel-overlay').removeClass('isvisible');
        }
      });

      $('.main-panel-overlay').on('click',function(){
        if($('#main_nav_trigger').is(':checked')) {
          $('#main_nav_trigger').trigger('click');
        }
      });
    }

    setLayout() {
      let w = window.innerWidth;
      let h = window.innerHeight;

      $('.main-navigation').css({
        width: this.mainNavWidth,
        height: h
      });

      $('.main-panel').css({
        width: w,
        height: h
      });

    }

  }

  $(document).ready(function(){
    const blackbox = new Blackbox;
    blackbox.load();
  });

</script>

