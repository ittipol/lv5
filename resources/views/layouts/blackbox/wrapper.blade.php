<div class="wrapper clearfix">

  @include('layouts.blackbox.components.action-bar')

  <div class="main-navigation pull-left">
    @include('layouts.blackbox.components.main-nav')
  </div>
  <div class="main-content pull-left">
    @yield('content')
  </div>
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

        $('.main-content').css({
          width: w,
          height: h
        });
      });

      $('#hamburger_menu_trigger_id').on('click',function(){
      
        if($(this).is(':checked')) {
          $('.main-navigation').css('left',0);
          $('.main-content').css('left',280);
          $('.action-bar').css('left',280);
        }else{
          $('.main-navigation').css('left',-280);
          $('.main-content').css('left',0);
          $('.action-bar').css('left',0);
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

      $('.main-content').css({
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

