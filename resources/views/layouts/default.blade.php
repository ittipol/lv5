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

	<header> 
		<?php if(!isset($header) || ($header)): ?>
			@include('layouts.header') 
		<?php endif; ?>
	</header>
	<main>
		@yield('content')
  </main>
  <footer> 
  	<?php if(isset($footer) && ($footer)): ?>
  		@include('layouts.footer') 
  	<?php endif; ?>
  </footer>

</body>
</html>