@extends('layouts.default')
@section('content')

<div class="container">
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          ร้านค้าหรือสถานประกอบการ
        </div>
      </div>

      <div class="col-lg-6">
        <a href="{{URL::to('company/add')}}" class="button pull-right">เพิ่มร้านค้าหรือสถาประกอบการ</a>
      </div>
    </div>
  </div>

  <div class="card-container row">

    <?php if(!empty($companies)):?>

      <?php foreach ($companies as $company): ?>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card medium">
          <div class="image-tile">
            <div class="image" style="background-image:url('<?php echo $company['image']; ?>');"></div>
            <div class="title"><?php echo $company['name']; ?></div>
          </div>
          <div class="button-group clear-fix">
            <div class="additional-option">
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="additional-option-items">
                <a href="{{URL::to('department/list')}}/<?php echo $company['id']; ?>">แสดงแผนก</a>
                <a href="{{URL::to('department/add/')}}/<?php echo $company['id']; ?>">เพิ่มแผนก</a>
                <a href="{{URL::to('job/add')}}/<?php echo $company['id']; ?>">ลงประกาศงาน</a>
                <a href="{{URL::to('company/report/<?php echo $company['id']; ?>')}}">รายชื่อผู้สมัครงาน</a>
              </div>
            </div>
            <a href="{{URL::to('company/view')}}/<?php echo $company['id']; ?>">แสดงเพิ่มเติม</a>
            <a href="{{URL::to('company/edit')}}/<?php echo $company['id']; ?>">แก้ไข</a>
            <a href="{{URL::to('company/delete')}}/<?php echo $company['id']; ?>">ลบ</a>
          </div>
        </div>
      </div>

      <?php endforeach; ?>

    <?php else: ?>

      <div class="col-lg-12">
        <h3>คุณยังไม่ได้เพิ่มร้านค้าหรือสถานประกอบการ</h3>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card medium">
          <div class="image-tile">
            <div class="image"></div>
          </div>
          <div class="button-group clear-fix">
          </div>
        </div>
      </div>


    <?php endif; ?>

  </div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    AdditionalOption.load();
  });
</script>

@stop