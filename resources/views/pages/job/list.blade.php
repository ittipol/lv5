@extends('layouts.default')
@section('content')

<div class="container">
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          งาน
        </div>
      </div>

      <div class="col-lg-6">
        <a href="{{URL::to('job/add')}}/<?php echo $companyId; ?>" class="button pull-right">ลงประกาศงาน</a>
      </div>
    </div>
  </div>

  <div class="card-container row">

    <?php if(!empty($jobs)):?>

      <?php foreach ($jobs as $job): ?>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card medium">
          <div class="image-tile">
            <div class="image" style="background-image:url('<?php echo $job['image']; ?>');"></div>
            <div class="title"><?php echo $job['name']; ?></div>
          </div>
          <div class="button-group clear-fix">
            <div class="additional-option">
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="additional-option-items">
                <a href="{{URL::to('department/list')}}/<?php echo $job['id']; ?>">แสดงแผนก</a>
              </div>
            </div>
            <a href="{{URL::to('job/view')}}/<?php echo $job['id']; ?>">หน้าหลัก</a>
            <a href="{{URL::to('job/edit')}}/<?php echo $job['id']; ?>">แก้ไข</a>
            <a href="{{URL::to('job/delete')}}/<?php echo $job['id']; ?>">ลบ</a>
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