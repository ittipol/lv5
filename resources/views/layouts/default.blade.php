<!doctype html>
<html>
<head>
  <!-- Meta data -->
  @include('includes.meta') 
  <!-- CSS & JS -->
  @include('includes.script')
  <!-- Title  -->
  <title>Chonburi Square</title>

  <link rel="stylesheet" href="{{ URL::asset('css/layouts/header.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('css/layouts/footer.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('css/pages/user/login.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('css/pages/user/register.css') }}" />
  
</head>
<body>

	<?php if(!isset($header) || ($header)): ?>
    <header> 
		 @include('layouts.default_header')
    </header> 
	<?php endif; ?>
	
	<main>
		@yield('content')
  </main>
  
	<?php if(isset($footer) && ($footer)): ?>
    <footer> 
		@include('layouts.default_footer')
    </footer> 
	<?php endif; ?>

</body>
</html>