<div class="wrapper clearfix">

  <div class="main-navigation pull-left">
    @include('layouts.blackbox.components.main-nav')
  </div>
  <div class="main-content pull-left">
    @include('layouts.blackbox.components.action-bar')
    @yield('content')
  </div>
</div>

<script type="text/javascript">

  class Layout {

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
    const layout = new Layout;
    layout.load();
  });

</script>
