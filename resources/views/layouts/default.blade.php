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

  <div class="floating-button">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>

  <div id="overlay_menu" class="overlay-menu">
    <a href="{{URL::to('account/add')}}">ไปยังร้านค้าออนไลน์</a>
    <a href="{{URL::to('account/add')}}">ไปยังร้านค้าหรือสถานประกอบการของคุณ</a>
    <a href="{{URL::to('account/add')}}">แสดงการขายของคุณ</a>
    <a href="{{URL::to('account/add')}}">แสดงโฆษณาของคุณ</a>
    <a href="{{URL::to('account/add')}}">แสดงการประกาศงานของคุณ</a>
  </div>

</body>
</html>