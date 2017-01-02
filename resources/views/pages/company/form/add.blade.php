@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          เพิ่มบริษัทหรือร้านค้าของคุณ
        </div>
      </div>
    </div>
  </div>

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

  <!-- <input type="hidden" name="__token" value="<?php echo $__token; ?>" > -->

  <?php
    echo Form::hidden('__token', $__token);
  ?>

  <div class="form-section">

    <div class="title">
      รายละเอียดบริษัทหรือร้านค้าของคุณ
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('name', 'ชื่อบริษัทหรือร้านค้าของคุณ', array(
            'class' => 'required'
          ));
          echo Form::text('name', null, array(
            'placeholder' => 'ชื่อบริษัทหรือร้านค้าของคุณ',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">ชื่อบริษัทหรือร้านค้าของคุณจะมีผลโดยตรงต่อการค้นหา</p>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('business_entity_id', 'รูปแบบธุรกิจ');
          echo Form::select('business_entity_id', $businessEntities ,null);
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('business_type', 'ประเภทธุรกิจ');
          echo Form::text('business_type', null, array(
            'placeholder' => 'ประเภทธุรกิจ',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">เช่น ก่อสร้าง, การขนส่ง, ไอที</p>
        <p class="notice info">ประเภทธุรกิจจะมีผลโดยตรงต่อการค้นหา</p>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('description', 'ข้อมูลบริษัทหรือร้านค้าของคุณ');
          echo Form::textarea('description', null, array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('brand_story', 'Brand Story');
          echo Form::textarea('brand_story', null, array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">

        <div class="sub-title">รูปภาพ</div>

        <div>
          <p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
          <p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
        </div>

        <div class="sub-form">

          <div class="sub-form-inner">

            <div class="form-row">
              <?php echo Form::label('', 'รูปภาพเครื่องหมายบริษัทหรือร้านค้าของคุณ'); ?>
              <div id="_image_logo"></div>
            </div>

            <div class="line"></div>

            <div class="form-row">
              <?php echo Form::label('', 'รูปภาพหน้าปก'); ?>
              <div id="_image_cover"></div>
            </div>

            <div class="line"></div>

            <div class="form-row">
              <?php echo Form::label('', 'รูปภาพบริษัทหรือร้านค้าของคุณ (สูงสุด 5 รูป)'); ?>
              <div id="_image_group"></div>
            </div>

          </div>
        
        </div>

      </div>

      <div class="form-row">

        <div class="sub-title">เวลาทำการ</div>

        <div class="sub-form">

          <div class="sub-form-inner">

            <div class="form-row">
              <?php 
                echo Form::checkbox('OfficeHour[same_time]', 1, null, array(
                  'id' => 'office_hour_same_time'
                ));
                echo Form::label('office_hour_same_time', 'กำหนดเวลาทำการเหมือนกันทุกวัน');
              ?>
            </div>

            <div class="line"></div>

            <div class="form-row">
              <p class="error-message">* ข้อมูลนี้จะไม่ถูกแสดง เมื่อคุณเลือกหยุดทำการทั้งหมด</p>
              <span class="office-status active"></span><span>&nbsp;เปิดทำการ</span>
              <span class="office-status"></span><span>&nbsp;หยุดทำการ</span>
            </div>

            <div id="_office_time"></div>

          </div>
        
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
        echo Form::label('Contact[phone_number]', 'เบอร์โทรศัพท์');
        echo Form::text('Contact[phone_number]', null, array(
          'placeholder' => 'เบอร์โทรศัพท์',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[website]', 'เว็บไซต์');
        echo Form::text('Contact[website]', null, array(
          'placeholder' => 'เว็บไซต์',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[email]', 'อีเมล');
        echo Form::text('Contact[email]', null, array(
          'placeholder' => 'อีเมล',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[facebook]', 'Facebook');
        echo Form::text('Contact[facebook]', null, array(
          'placeholder' => 'Facebook',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[instagram]', 'Instagram');
        echo Form::text('Contact[instagram]', null, array(
          'placeholder' => 'Instagram',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[line]', 'Line');
        echo Form::text('Contact[line]', null, array(
          'placeholder' => 'Line',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ที่อยู่บริษัทหรือร้านค้าของคุณ
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('Address[address]', 'ที่อยู่');
          echo Form::textarea('Address[address]', null, array(
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
          echo Form::label('Address[district_id]', 'อำเภอ', array(
            'class' => 'required'
          ));
          echo Form::select('Address[district_id]', $districts ,null, array(
            'id' => 'district'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[sub_district_id]', 'ตำบล', array(
            'class' => 'required'
          ));
          echo Form::select('Address[sub_district_id]', array('0' => '-') , null, array(
            'id' => 'sub_district'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php echo Form::label('', 'ระบุตำแหน่งบริษัทหรือร้านค้าของคุณบนแผนที่'); ?>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      แท๊ก
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('_tags', 'แท๊กที่เกี่ยวข้องกับบริษัทหรือร้านค้าของคุณของคุณ');
        ?>
        <div id="_tags" class="tag"></div>
        <p class="notice info">แท็กจะช่วยให้การค้นหาบริษัทหรือร้านค้าของคุณของคุณง่ายขึ้น</p>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      Wiki ชลบุรี
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <p class="error-message">* สามารถเพิ่มหรือลบได้ในภายหลัง</p>
        <?php 
          echo Form::checkbox('wiki', 1, null, array(
            'id' => 'wiki'
          ));
          echo Form::label('wiki', 'อนุญาตให้นำข้อมูลบริษัทหรือร้านค้าของคุณของคุณลงใน Wiki ชลบุรี');
        ?>
        <p class="notice info">Wiki จะเป็นระบบในการจัดเก็บข้อมูลต่างๆ ใยชลบุรี และจะทำให้ง่ายต่อการค้นหาและเข้าถึง</p>
      </div>

    </div>

  </div>

  <?php
    echo Form::submit('เพิ่มสถานประกอบการหรือร้านค้าของคุณ', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">

  $(document).ready(function(){

    const logo = new Images('_image_logo','logo',1,'default');
    logo.load();

    const cover = new Images('_image_cover','cover',1,'default');
    cover.load();

    const images = new Images('_image_group','images',5,'default');
    images.load();
    
    const tagging = new Tagging();
    tagging.load();

    const district = new District();
    district.load();

    const map = new Map();
    map.load();
    
    const officeHour = new OfficeHour();
    officeHour.load();

    const form = new Form();
    form.load();
  });
</script>

@stop