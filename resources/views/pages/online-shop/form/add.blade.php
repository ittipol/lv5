@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          เพิ่มร้านค้า
        </div>
      </div>
    </div>
  </div>
// ให้ลูกค้าเลือกได้ว่าจะให้มีการกด order แล้วตัด stock
// หรือ ใช้การติดต่อเท่านั้น
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
      ข้อมูลทั่วไป
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อร้านค้า', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อร้านค้า',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
    </div>

    <div class="form-row">

      <?php 
        echo Form::label('_tag_items', 'ร้านค้าของคุณขายอะไรบ้าง');
      ?>
      <p class="error-message">* สามารถแก้ไขได้ในภายหลัง</p>
      <div id="_tag_items" class="tag"></div>
      <p class="notice info">ข้อมูลนี้จะให้ลูกค้ารู้ว่าคุณขายอะไรบ้างและทำให้พบสินค้าของคุณง่ายขึ้น</p>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดร้านค้า', array(
          'class' => 'required'
        ));
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
            <?php echo Form::label('', 'รูปภาพเครื่องหมายร้านค้า'); ?>
            <div id="_image_logo"></div>
          </div>

          <div class="line"></div>

          <div class="form-row">
            <?php echo Form::label('', 'รูปภาพหน้าปก'); ?>
            <div id="_image_cover"></div>
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
      แท๊ก
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('_tags', 'แท๊กที่เกี่ยวข้องกับร้านค้า');
        ?>
        <div id="_tags" class="tag"></div>
        <p class="notice info">แท็กจะช่วยให้การค้นหาร้านค้าของคุณง่ายขึ้น</p>
      </div>

    </div>

  </div>

  <?php
    echo Form::submit('เพิ่มร้านค้า', array(
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

    const images = new Images('_image_cover','images',1,'default');
    images.load();

    const shopHasItem = new Tagging();
    shopHasItem.setPanel('_tag_items');
    shopHasItem.setDataName('shopHasItem');
    shopHasItem.setPlaceHolder('สินค้าอะไรบ้างที่ขายในร้าน');
    shopHasItem.load();

    const tagging = new Tagging();
    tagging.load();

    const form = new Form();
    form.load();

  });
</script>

@stop