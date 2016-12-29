@extends('layouts.default')
@section('content')

<div class="container">
  <h2><?php echo $companyName; ?></h2>
  <h2>เพิ่มแผนก</h2>

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

  <input type="hidden" name="__token" value="<?php echo $__token; ?>" >

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

        <div class="sub-title">รูปภาพ</div>

        <div>
          <p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
          <p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
        </div>

        <div class="sub-form">

          <div class="sub-form-inner">

            <div class="form-row">
              <?php echo Form::label('', 'รูปภาพสัญลักษณ์ของแผนก'); ?>
              <div id="_image_logo">
              </div>
            </div>

            <div class="line"></div>

            <div class="form-row">
              <?php echo Form::label('', 'รูปภาพแผนก (สูงสุด 5 รูป)'); ?>
              <div id="_image_group">
              </div>
            </div>

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
      Wiki ชลบุรี
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <p class="error-message">* สามารถเพิ่มหรือลบได้ในภายหลัง</p>
        <?php 
          echo Form::checkbox('wiki', 1, null, array(
            'id' => 'wiki'
          ));
          echo Form::label('wiki', 'อนุญาตให้นำข้อมูลร้านค้าหรือสถานประกอบการของคุณลงใน Wiki ชลบุรี');
        ?>
        <p class="notice info">Wiki จะเป็นระบบในการจัดเก็บข้อมูลต่างๆ ใยชลบุรี และจะทำให้ง่ายต่อการค้นหาและเข้าถึง</p>
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

    const logo = new Images('_image_logo','logo',1,'default');
    logo.load();

    const images = new Images('_image_group','images',5,'default');
    images.load();

    Map.load();
    
    const form = new Form();
    form.load();
  });
</script>

@stop