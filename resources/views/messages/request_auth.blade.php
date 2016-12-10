@extends('layouts.default')
@section('content')
<div class="container">
  <div class="message">
    <div class="message-inner">
      <div class="title">กรุณาเข้าสู่ระบบ</div>
      <p class="description">หน้าที่คุณเรียกนั้น จำเป็นต้องเข้าสู่ระบบก่อนเพื่อการทำงานที่ถูกต้อง</p>
      <a href="{{URL::to('login')}}" class="button">เข้าสู่ระบบ</a>
    </div>
  </div>
</div>
@stop