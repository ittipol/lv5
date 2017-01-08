@extends('layouts.default')
@section('content')

<div class="container">
  <div class="row">
    <div class="container-header">
      <div class="col-lg-6">
        <div class="title">
          เพิ่มสินค้า
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

  <input type="hidden" name="__token" value="<?php echo $__token; ?>" >

  <div class="form-section">

    <div class="title">
      ข้อมูลของสินค้า
    </div>

    <div class="form-row">
      <?php 
        // echo Form::label('categories', 'หมวดหมู่การโฆษณา');
        // echo Form::select('type', $categories ,null);
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อสินค้า', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อสินค้า',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดสินค้า', array(
          'class' => 'required'
        ));
        echo Form::textarea('description', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    // ขายเป็นชิ้น กิโล
    // ระบบ promotion

    <div class="form-row">
      <?php 
        echo Form::label('price', 'ราคา');
        echo Form::text('price', null, array(
          'placeholder' => 'ราคา',
          'autocomplete' => 'off'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('price', 'จำนวนสินค้า');
      ?>
      <p class="error-message">* จำนวนสินค้าของจะลดลงทุกครั้งตามจำนวนสินค้าที่ลูกค้าสั่ง</p>
      <p class="error-message">* เมื่อสินค้าเหลือ 0 ระบบจะแสดงข้อความ "สินค้าหมด" ให้ทันที</p>
      <p class="error-message">* คุณสามารถกำหนดข้อความเมื่อสินค้าหมดเองได้</p>
      <p class="error-message">* สามารถเพิ่ม ลด จำนวนสินค้าได้ในภายหลัง</p>
      <?php
        echo Form::text('price', null, array(
          'placeholder' => 'จำนวนสินค้า',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">กรุณากรอกเป็นตัวเลข</p>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('price', 'ข้อความที่จะแสดงเมื่อสินค้าหมด');
      ?>
      <p class="error-message">* สามารถแก้ไขภายหลังได้</p>
      <?php
        echo Form::text('price', null, array(
          'placeholder' => 'ราคา',
          'autocomplete' => 'off'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php echo Form::label('images', 'รูปภาพสินค้า (สูงสุด 8 รูป)'); ?>
      <p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
      <p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
      <div id="_image_group"></div>
    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ตัวเลือกเสริมและกลุ่มเป้าหมาย
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('', 'เพศ');
      ?>

      <?php
        echo Form::checkbox('target_gender', 'm');
      ?>
      <span>ชาย</span>
      <br/>
      <?php
        echo Form::checkbox('target_gender', 'f');
      ?>
      <span>หญิง</span>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('', 'กลุ่มเป้าหมาย');
      ?>

      <?php
        echo Form::checkbox('target_age', '15:24');
      ?>
      <span>15 - 24</span>
      <br/>
      <?php
        echo Form::checkbox('target_age', '25:34');
      ?>
      <span>25 - 34</span>
      <br/>
      <?php
        echo Form::checkbox('target_age', '35:44');
      ?>
      <span>35 - 44</span>
      <br/>
      <?php
        echo Form::checkbox('target_age', '45:54');
      ?>
      <span>45 - 54</span>
      <br/>
      <?php
        echo Form::checkbox('target_age', '55:60');
      ?>
      <span>55 - 60</span>
      <br/>
      <?php
        echo Form::checkbox('target_age', '61');
      ?>
      <span>61 ขึ้นไป</span>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('price', 'เลือกช่วงเวลาที่เหมาะสมที่สุด สำหรับการแสดงโฆษณาของคุณ');
        echo Form::text('price', null, array(
          'placeholder' => 'ราคา',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ข้อมูลนี้จะทำให้โฆษณาของคุณแสดงตรงข่วงเวลาที่เหมาะสมที่สุด</p>
    </div>

  </div>

  <div class="form-section">

    <div class="title">
      แท๊ก
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('categories', 'แท๊ก (เช่น เสื้อยืด, โทนเนอร์, โคมไฟ, อาหารญี่ปุ่น)');
      ?>
      <div id="tags" class="tag"></div>
      <p class="notice info">แท็กจะช่วยให้การค้นหาโฆษณาของคุณง่ายขึ้น</p>
    </div>

  </div>

  <div class="form-row">

  </div>

  <?php
    echo Form::submit('ลงโฆษณา', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">
  $(document).ready(function(){

    var images = new Images('_image_group','images',5,'default');
    images.load();

    Tagging.load();

    Form.load();

  });
</script>

@stop