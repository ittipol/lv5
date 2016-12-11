@extends('layouts.default')
@section('content')

<div class="container">
  <h2><?php echo $companyName; ?></h2>
  <h2>แผนก</h2>

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
              <a href="{{URL::to('job/add/<?php echo $department['id']; ?>')}}">ลงประกาศงาน</a>
              <a href="{{URL::to('department/report/<?php echo $department['id']; ?>')}}">รายชื่อผู้สมัครงาน</a>
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