<?php
  require 'minify/minify-js.php';
  require 'minify/minify-css.php';
?>

<?php

  $jsFiles = array(
    'js/jquery-3.1.1.min.js',
    'js/jquery.validate.min.js',
    'js/map/google-map.js',
    'js/map/map.js',
    'js/forms/form.js',
    'js/forms/images.js',
    'js/forms/office_hour.js',
    'js/forms/district.js',
    'js/components/tagging.js',
    'js/components/notification-bottom.js',
    'js/components/additional-option.js',
    'js/components/custom-scroll.js',
    'js/components/filter.js'
  );

  $code = '';
  foreach ($jsFiles as $js) {
    $code .= file_get_contents($js);
  }

  $_js = JSMin::minify($code);

  if(!file_exists(public_path().'/js/script.min.js') || (strlen($_js) != filesize(public_path().'/js/script.min.js'))){
    file_put_contents('js/script.min.js', $_js);
  }
  
?>

<script type="text/javascript" src="{{ URL::asset('js/script.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>

<?php
  $cssFiles = array(
    'css/bootstrap.min.css',
    'css/core.css',
    'css/map.css',
    'css/messages/message.css',
    'css/components/notification-bottom.css',
    'css/components/form.css',
    'css/components/tag.css',
    'css/components/card.css',
    'css/components/button.css',
    'css/components/switch.css',
    'css/components/additional-option.css',
    'css/components/custom-scroll.css',
    'css/components/filter-panel.css',
    'css/pages/entity.css',
    'css/blackbox/wrapper.css',
    'css/blackbox/components/action-bar.css',
    'css/blackbox/components/main-nav.css',
    'css/blackbox/components/main-panel.css',
    'css/blackbox/responsive.css',
  );

  $code = '';
  foreach ($cssFiles as $css) {
    $code .= file_get_contents($css);
  }

  $_css = CSSMin::minify($code);

  if(!file_exists(public_path().'/css/script.min.css') || (strlen($_css) != filesize(public_path().'/css/script.min.css'))){
    file_put_contents('css/script.min.css', $_css);
  }

?>

<link rel="stylesheet" href="{{ URL::asset('css/script.min.css') }}" />

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