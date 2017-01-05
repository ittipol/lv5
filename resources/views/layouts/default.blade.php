<!doctype html>
<html>
<head>
  <!-- Meta data -->
  @include('includes.meta') 
  <!-- CSS & JS -->
  @include('includes.script')
  <!-- Title  -->
  <title>Chonburi Square</title>
  <!-- use only in default layout -->
  <link rel="stylesheet" href="{{ URL::asset('__css/layouts/header.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('__css/layouts/footer.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('__css/pages/user/register.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('__css/pages/user/login.css') }}" />
  
</head>
<body>

	<?php if(!empty($header)): ?>
    <header> 
		 @include('layouts.default_header')
    </header> 
	<?php endif; ?>
	
	<main>
		@yield('content')
  </main>
  
	<?php if(!empty($footer)): ?>
    <footer> 
		@include('layouts.default_footer')
    </footer> 
	<?php endif; ?>

</body>
</html>