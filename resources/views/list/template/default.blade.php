@extends('layouts.blackbox.main')
@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          <?php echo $title; ?>
        </div>
      </div>

      <!-- <div class="col-lg-6">
        <a href="{{URL::to('list/add')}}" class="button pull-right">เพิ่มสถานประกอบการหรือร้านค้า</a>
      </div> -->

    </div>
  </div>

  <div class="line"></div>

  @include('layouts.blackbox.components.filter-panel')
  
  <section class="card-list">

    <div class="card-container row">

      <?php if(!empty($lists)):?>

        <?php foreach ($lists as $list): ?>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="card medium">
            <div class="image-tile" style="background-image: url('<?php echo $list['cover']; ?>');">
              <div class="title"><?php echo $list['name']; ?></div>
            </div>
            <div class="button-group clear-fix">
              <div class="additional-option">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="additional-option-content">
                  <a href="{{URL::to('department/add/')}}/<?php echo $list['id']; ?>">เพิ่มสาขา</a>
                  <a href="{{URL::to('department/list')}}/<?php echo $list['id']; ?>">แสดงแผนก</a>
                  <a href="{{URL::to('department/add/')}}/<?php echo $list['id']; ?>">เพิ่มแผนก</a>
                  <a href="{{URL::to('job/add')}}/<?php echo $list['id']; ?>">ลงประกาศงาน</a>
                  <a href="{{URL::to('list/report/<?php echo $list['id']; ?>')}}">แสดงรายชื่อผู้สมัครงาน</a>
                </div>
              </div>
              <?php if(!empty($list['slug'])): ?>
                <a href="<?php echo $list['slug']['url']; ?>">
                  <img src="/images/icons/home.png">
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php endforeach; ?>

      <?php else: ?>

        <div class="col-lg-12">
          <h3>ไม่พบข้อมูล<?php echo $title; ?></h3>
        </div>

      <?php endif; ?>

    </div>

  </section>

</div>
@stop