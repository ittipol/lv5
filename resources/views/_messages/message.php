@extends('layouts.default')
@section('content')
<div class="container">
  <div class="message">
    <div class="message-inner">
      <div class="title"><?php $title; ?></div>
      <p class="description"><?php $message; ?></p>
    </div>
  </div>
</div>
@stop