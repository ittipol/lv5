<!doctype html>
<html>
<head>
	<!-- <meta charset="utf-8"> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Chonburi Square</title>
	<!-- my head section goes here -->
	@include('includes.script') 

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