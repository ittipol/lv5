<?php
  require 'minify/minify-js.php';
  require 'minify/minify-css.php';
?>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places"></script> -->

<?php

  $jsFiles = array(
    '__js/jquery-3.1.1.min.js',
    '__js/jquery.validate.min.js',
    '__js/blackbox/blackbox.js',
    '__js/library/token.js',
    // '__js/map/google-map.js',
    '__js/map/map.js',
    '__js/forms/form.js',
    '__js/forms/images.js',
    '__js/forms/office_hour.js',
    '__js/forms/district.js',
    '__js/components/tagging.js',
    '__js/components/notification-bottom.js',
    '__js/components/additional-option.js',
    '__js/components/custom-scroll.js',
    '__js/components/filter.js'
  );

  $code = '';
  foreach ($jsFiles as $js) {
    $code .= file_get_contents($js);
  }

  $_js = JSMin::minify($code);

  if(!file_exists(public_path().'/js/8fcf1793a14f7d35.js') || (strlen($_js) != filesize(public_path().'/js/8fcf1793a14f7d35.js'))){
    file_put_contents('js/8fcf1793a14f7d35.js', $_js);
  }
  
?>

<script type="text/javascript" src="{{ URL::asset('js/8fcf1793a14f7d35.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>

<?php
  $cssFiles = array(
    '__css/bootstrap.min.css',
    '__css/core.css',
    '__css/map/map.css',
    '__css/messages/message.css',
    '__css/components/notification-bottom.css',
    '__css/components/form.css',
    '__css/components/tag.css',
    '__css/components/card.css',
    '__css/components/button.css',
    '__css/components/switch.css',
    '__css/components/additional-option.css',
    '__css/components/custom-scroll.css',
    '__css/components/filter-panel.css',
    '__css/pages/entity.css',
    '__css/blackbox/wrapper.css',
    '__css/blackbox/components/action-bar.css',
    '__css/blackbox/components/main-nav.css',
    '__css/blackbox/components/main-panel.css',
    '__css/blackbox/responsive.css'
  );

  $code = '';
  foreach ($cssFiles as $css) {
    $code .= file_get_contents($css);
  }

  $_css = CSSMin::minify($code);

  if(!file_exists(public_path().'/css/a590bf3e950e330b.css') || (strlen($_css) != filesize(public_path().'/css/a590bf3e950e330b.css'))){
    file_put_contents('css/a590bf3e950e330b.css', $_css);
  }

?>

<link rel="stylesheet" href="{{ URL::asset('css/a590bf3e950e330b.css') }}" />

@if (Auth::check())
  @if(Session::has('message.title') && Session::has('message.type'))
  <script type="text/javascript">
    $(document).ready(function(){

      let title = '{{ Session::get("message.title") }}';
      let type = '{{ Session::get("message.type") }}';
      let desc = '';
      @if(Session::has('message.desc'))
        desc = '{{ Session::get("message.desc") }}';
      @endif

      const notificationBottom = new NotificationBottom(title,desc,type);
      notificationBottom.load();

    });
  </script>
  @endif
@endif