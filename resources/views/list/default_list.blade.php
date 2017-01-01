@extends('layouts.blackbox.main')
@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          บริษัทหรือร้านค้าของคุณของคุณ
        </div>
      </div>

      <!-- <div class="col-lg-6">
        <a href="{{URL::to('entity/add')}}" class="button pull-right">เพิ่มสถานประกอบการหรือร้านค้า</a>
      </div> -->

    </div>
  </div>

  <div class="line"></div>

  <div class="filter-panel pull-right">

  </div>

  <section class="card-list">

    <div class="card-container row">

      <?php if(!empty($entities)):?>

        <?php foreach ($entities as $entity): ?>

        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
          <div class="card medium">
            <div class="image-tile" style="background-image: url('/images/bb1.jpg');">
              <!-- <div class="image" style="background-image:url('<?php echo $entity['image']; ?>');"></div> -->
              <div class="title"><?php echo $entity['name']; ?></div>
            </div>
            <div class="button-group clear-fix">
              <div class="additional-option">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="additional-option-content">
                  <a href="{{URL::to('department/add/')}}/<?php echo $entity['id']; ?>">เพิ่มสาขา</a>
                  <a href="{{URL::to('department/list')}}/<?php echo $entity['id']; ?>">แสดงแผนก</a>
                  <a href="{{URL::to('department/add/')}}/<?php echo $entity['id']; ?>">เพิ่มแผนก</a>
                  <a href="{{URL::to('job/add')}}/<?php echo $entity['id']; ?>">ลงประกาศงาน</a>
                  <a href="{{URL::to('entity/report/<?php echo $entity['id']; ?>')}}">แสดงรายชื่อผู้สมัครงาน</a>
                </div>
              </div>
              <?php if(!empty($entity['slug'])): ?>
                <a href="{{URL::to('entity/delete')}}/<?php echo $entity['slug']['url']; ?>">
                  <img src="/images/icons/home.png">
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php endforeach; ?>

      <?php else: ?>

        <div class="col-lg-12">
          <h3>คุณยังไม่ได้เพิ่มบริษัทหรือร้านค้าของคุณของคุณ</h3>
        </div>

      <?php endif; ?>

    </div>

  </section>

</div>
@stop