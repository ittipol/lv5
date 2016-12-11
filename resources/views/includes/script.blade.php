<!-- css and js goes here -->
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.modal.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/form.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/images.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/item_images.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/forms/district.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/tag.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/floating-menu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/notification-bottom.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/additional-option.js') }}"></script>

<?php if(file_exists($jsPath)): ?>
<script type="text/javascript" src="<?php echo $root.$jsPath; ?>"></script>
<?php endif; ?>

<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/jquery.modal.css') }}" /><link rel="stylesheet" href="{{ URL::asset('css/core.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/map.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/messages/message.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/layouts/header.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/layouts/footer.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/notification-bottom.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/form.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/tag.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/card.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/button.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/modal.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/components/additional-option.css') }}" />

<?php if(file_exists($cssPath)): ?>
<link rel="stylesheet" href="<?php echo $root.$cssPath; ?>" />
<?php endif; ?>

@if(Session::has('message.title') && Session::has('message.type'))
<script type="text/javascript">
  $(document).ready(function(){
    NotificationBottom.title = '{{ Session::get("message.title") }}';
    NotificationBottom.type = '{{ Session::get("message.type") }}';
    @if(Session::has('message.desc'))
      NotificationBottom.desc = '{{ Session::get("message.desc") }}';
    @endif
    NotificationBottom.load();
  });
</script>
@endif