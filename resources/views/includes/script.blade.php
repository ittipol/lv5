<!-- css and js goes here -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places"></script>

<script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/map/map.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/form.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/images.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/office_hour.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/district.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/tagging.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/notification-bottom.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/additional-option.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/scroll.js') }}"></script>

<?php if(file_exists($jsPath)): ?>
<script type="text/javascript" src="<?php echo $root.$jsPath; ?>"></script>
<?php endif; ?>

<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/core.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/map.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/messages/message.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/notification-bottom.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/form.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/tag.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/card.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/button.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/switch.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/additional-option.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/scroll.css') }}" />

<link rel="stylesheet" href="{{ URL::asset('css/pages/entity.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/blackbox/wrapper.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/blackbox/components/action-bar.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/blackbox/components/main-nav.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/blackbox/responsive.css') }}" />

<?php if(file_exists($cssPath)): ?>
<link rel="stylesheet" href="<?php echo $root.$cssPath; ?>" />
<?php endif; ?>

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