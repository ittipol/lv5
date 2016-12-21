@extends('layouts.default')
@section('content')

<div class="container">
  <h2><?php echo $companyName; ?></h2>
  <h2>แผนก</h2>

  <?php if(!empty($errors->all())): ?>
    <div class="form-error-messages">
      <div class="form-error-messages-inner">
        <h3>เกิดข้อผิดพลาด!!!</h3>
          <ul>
          <?php foreach ($errors->all() as $message) { ?>
            <li class="error-messages"><?php echo $message; ?></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <?php
    echo Form::open(['method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <div class="form-section">

    <div class="title">
      ข้อมูลแผนก
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('name', 'ชื่อแผนก', array(
            'class' => 'required'
          ));
          echo Form::text('name', null, array(
            'placeholder' => 'ชื่อแผนก',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">ชื่อแผนกจะมีผลโดยตรงต่อการค้นหา</p>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('description', 'ข้อมูลแผนก');
          echo Form::textarea('description', null, array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php echo Form::label('', 'รูปภาพแผนก (สูงสุด 5 รูป)'); ?>
        <p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
        <p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
        <div id="_image_group">
        </div>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ข้อมูลการติดต่อ
    </div>

    <div class="form-section-inner">

      <div class="form-row">
      <?php 
        echo Form::label('mobile_phone', 'เบอร์โทรศัพท์');
        echo Form::text('mobile_phone', null, array(
          'placeholder' => 'เบอร์โทรศัพท์',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('email', 'อีเมล');
        echo Form::text('email', null, array(
          'placeholder' => 'อีเมล',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('fb', 'Facebook');
        echo Form::text('fb', null, array(
          'placeholder' => 'Facebook',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('instagram', 'Instagram');
        echo Form::text('instagram', null, array(
          'placeholder' => 'Instagram',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('line', 'Line');
        echo Form::text('line', null, array(
          'placeholder' => 'Line',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ที่อยู่แผนก
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <p class="error-message">* เมื่อคุณเลือกตัวเลือกนี้ ข้อมูลที่อยู่แผนกจะไม่ถูกบันทึก</p>
        <?php
        echo Form::checkbox('company_address', 1, false);
        echo Form::label('company_address', 'ที่อยู่เดียวกับสถานประกอบการ');
      ?>
      </div>

      <div class="line"></div>

      <div class="form-row">
        <?php 
          echo Form::label('address', 'ที่อยู่');
          echo Form::textarea('address', null, array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('province', 'จังหวัด');
          echo Form::text('province', 'ชลบุรี', array(
            'placeholder' => 'จังหวัด',
            'autocomplete' => 'off',
            'disabled' => 'disabled'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('district_id', 'อำเภอ', array(
            'class' => 'required'
          ));
          echo Form::select('district_id', $districts ,null, array(
            'id' => 'district'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('sub_district_id', 'ตำบล', array(
            'class' => 'required'
          ));
          echo Form::select('sub_district_id', array('0' => '-') , null, array(
            'id' => 'sub_district'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php echo Form::label('', 'ระบุตำแหน่งบนแผนที่ เพื่อง่ายต่อการค้นหา'); ?>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      Wiki ชลบุรี
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::checkbox('wiki', 1);
          echo Form::label('wiki', 'อนุญาตให้นำข้อมูลแผนกของคุณลงใน Wiki ชลบุรี');
        ?>
      </div>

    </div>

  </div>

  <?php
    echo Form::submit('เพิ่มแผนก', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    Images.load();
    District.load();
    Map.load();
  });
</script>

<script type="text/javascript" src="{{ URL::asset('js/map/map.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places&callback=initAutocomplete"
     async defer></script>

@stop