@extends('layouts.default')
@section('content')

<div class="container">
  <h2><?php echo $companyName; ?></h2>
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          แผนก
        </div>
      </div>

      <div class="col-lg-6">
        <a href="{{URL::to('department/add')}}/<?php echo $companyId; ?>" class="button pull-right">เพิ่มแผนก</a>
      </div>
    </div>
  </div>

  <div class="card-container row">

    <?php foreach ($departments as $department): ?>

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="card medium">
        <div class="image-tile">
          <div class="image" style="background-image:url('<?php echo $department['image']; ?>');"></div>
          <div class="title"><?php echo $department['name']; ?></div>
        </div>
        <div class="button-group clear-fix">
          <div href="javascript:void(0)" class="additional-option">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-items">
              <a href="{{URL::to('job/add')}}/<?php echo $department['id']; ?>">ลงประกาศงาน</a>
              <a href="{{URL::to('department/report')}}/<?php echo $department['id']; ?>">รายชื่อผู้สมัครงาน</a>
            </div>
          </div>
          <a href="{{URL::to('department/view')}}/<?php echo $department['id']; ?>">แสดงเพิ่มเติม</a>
          <a href="{{URL::to('department/edit')}}/<?php echo $department['id']; ?>">แก้ไข</a>
          <a href="{{URL::to('department/delete')}}/<?php echo $department['id']; ?>">ลบ</a>
        </div>
      </div>
    </div>

    <?php endforeach; ?>

  </div>

</div>
@stop