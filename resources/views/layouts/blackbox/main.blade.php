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
        // this.filterPanelOriginalTop;
        // this.filterPanelOriginalHeight;
        // this.filterPanelExtendHeight;
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

          // $('.filter-panel').css({
          //   height: h - 60
          // });

          if(w > 992) {
            if($('#main_nav_trigger').is(':checked')) {
              $('#main_nav_trigger').trigger('click');
            }

            // if($('#filter_panel_trigger').is(':checked')) {
            //   $('#filter_panel_trigger').trigger('click');
            // }

            // $('.filter-panel').css({
            //   height: h - $('.filter-panel').offset().top
            // });
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

          // if($('#filter_panel_trigger').is(':checked')) {
          //   $('#filter_panel_trigger').trigger('click');
          // }
        });

        $('.action-bar-overlay').on('click',function(){
          if($('#main_nav_trigger').is(':checked')) {
            $('#main_nav_trigger').trigger('click');
          }
        });

        // $('#filter_panel_trigger').on('click',function(){
        //   if($(this).is(':checked')) {
        //     $('.filter-panel').addClass('is-filter-panel-open');
        //     $('.main-panel-overlay').addClass('isvisible');
        //   }else{
        //     $('.filter-panel').removeClass('is-filter-panel-open');
        //     $('.main-panel-overlay').removeClass('isvisible');
        //   }
        // }); 

        // $(".nano").on("update", function(event, vals){ 
        //    // console.log("pos=" + vals.position + ", direction=" + vals.direction + "\n" )

        //    if(vals.position > _this.filterPanelOriginalTop) {
        //     $('.filter-panel').css({
        //       top: vals.position,
        //       height: _this.filterPanelExtendHeight
        //     });
        //    }else{
        //     $('.filter-panel').css({
        //       top: _this.filterPanelOriginalTop,
        //       height: _this.filterPanelOriginalHeight
        //     });
        //    }

        // });

        // $(".nano").bind("scrolltop", function(e){
        //     console.log('top');
        // });

        // $(".nano").bind("scrollend", function(e){
        //     console.log('end');
        // });
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

        // this.filterPanelOriginalTop = $('.filter-panel').position().top;
        // this.filterPanelOriginalHeight = h - $('.filter-panel').offset().top;
        // this.filterPanelExtendHeight = this.filterPanelOriginalHeight + this.filterPanelOriginalTop;

        // $('.filter-panel').css({
        //   height: this.filterPanelOriginalHeight
        // });

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

</body>
</html>