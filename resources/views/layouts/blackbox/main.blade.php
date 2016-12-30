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

</body>
</html>