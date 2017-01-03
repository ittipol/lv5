<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Chonburi Square</title>
  <!-- my head section goes here -->
  @include('includes.script') 
</head>
<body>

  <main>
    @include('layouts.blackbox.wrapper')
  </main>

  <script type="text/javascript">

    class Blackbox {

      constructor() {
        this.mainNavWidth = 280;
      }

      load(){
        this.bind();
        this.setLayout();
      }

      bind() {

        let _this = this;

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

          if($('#filter_panel_trigger').is(':checked')) {
            $('#filter_panel_trigger').trigger('click');
          }

          if($(this).is(':checked')) {
            $('.main-navigation').addClass('is-main-nav-open');
            $('.main-panel').addClass('is-main-nav-open');
            $('.action-bar').addClass('is-main-nav-open');
            $('.main-panel-overlay').addClass('isvisible');
            $('.action-bar-overlay').addClass('isvisible');
          }else{
            $('.main-navigation').removeClass('is-main-nav-open');
            $('.main-panel').removeClass('is-main-nav-open');
            $('.action-bar').removeClass('is-main-nav-open');
            $('.main-panel-overlay').removeClass('isvisible');
            $('.action-bar-overlay').removeClass('isvisible');
          }
        });

        $('.main-panel-overlay').on('click',function(){
          if($('#main_nav_trigger').is(':checked')) {
            $('#main_nav_trigger').trigger('click');
          }
        });

        $('.action-bar-overlay').on('click',function(){
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

      loadMainNav() {

      }

    }

    $(document).ready(function(){
      const additionalOption = new AdditionalOption();
      additionalOption.load();

      const blackbox = new Blackbox;
      blackbox.load();

      setTimeout(function(){
        $(".nano").nanoScroller();
      },500);
    });
    
  </script>

  @if (!Auth::check())

    <script type="text/javascript">
      $(document).ready(function(){
        let title = 'เข้าถึงเนื้อหาและร้านค้าทั้งหมดด้วยการเข้าสู่ระบบ';
        let desc = '';
        desc += '<div class="button-group">';
        desc += '<a class="button" href="login">เข้าสู่ระบบ</a>';
        desc += '<a class="button" href="select_registation">สมัครสมาชิก</a>';
        desc += '</div>';

        const notificationBottom = new NotificationBottom(title,desc,'','medium',true);
        notificationBottom.load();
      });
    </script>
  @endif

</body>
</html>