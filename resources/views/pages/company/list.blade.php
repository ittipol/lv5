@extends('layouts.default')
@section('content')

<div>
<div class="container">
<h2>ร้านค้าหรือสถานประกอบการของคุณ</h2>
</div>
</div>

<div class="container">
  <h2>ร้านค้าหรือสถานประกอบการของคุณ</h2>

  <div class="card-container row">

    <?php foreach ($companies as $company): ?>

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="card medium">
        <div class="image-tile">
          <div class="image" style="background-image:url('<?php echo $company['image']; ?>');"></div>
          <div class="title"><?php echo $company['name']; ?></div>
        </div>
        <div class="button-group clear-fix">
          <div href="javascript:void(0)" class="additional-option">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-items">
              <a href="{{URL::to('department/list')}}/<?php echo $company['id']; ?>">แสดงแผนก</a>
              <a href="{{URL::to('department/add/')}}/<?php echo $company['id']; ?>">เพิ่มแผนก</a>
              <a href="{{URL::to('job/add/<?php echo $company['id']; ?>')}}">ลงประกาศงาน</a>
              <a href="{{URL::to('company/report/<?php echo $company['id']; ?>')}}">รายชื่อผู้สมัครงาน</a>
            </div>
          </div>
          <a href="{{URL::to('company/view')}}">แสดงเพิ่มเติม</a>
          <a href="{{URL::to('company/edit')}}">แก้ไข</a>
          <a href="{{URL::to('company/delete')}}">ลบ</a>
        </div>
      </div>
    </div>

    <?php endforeach; ?>

  </div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    AdditionalOption.load();
  });
</script>

@stop