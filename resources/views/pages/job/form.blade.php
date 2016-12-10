@extends('layouts.default')
@section('content')

<div>
  <div class="container">
    <h2>ลงประกาศงาน</h2>
  </div>
</div>

<div class="container">
  <h2>ลงประกาศงาน</h2>

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
      ร้านค้าหรือสถานประกอบการของคุณ
    </div>

    <div class="form-section-inner">

      <div class="form-row">

        <?php 
          echo Form::label('comapny', 'ร้านค้าหรือสถานประกอบการ', array(
            'class' => 'required'
          ));
          echo Form::select('comapny', array() ,null);
        ?>
        
        <?php 
          echo Form::label('department', 'แผนก (ถ้ามี)');
          echo Form::select('department', array() ,null);
        ?>

      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ข้อมูลตำแหน่งงาน
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('subject', 'หัวข้อ', array(
            'class' => 'required'
          ));
          echo Form::text('subject', null, array(
            'placeholder' => 'หัวข้อ',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('salary', 'เงินเดือน (บาท)', array(
            'class' => 'required'
          ));
          echo Form::text('salary', null, array(
            'placeholder' => 'เงินเดือน',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น 10000 - 20000 บาท หรือ สามารถต่อรองได้</p>
      </div>

      <div class="form-row">

        <div class="sub-title">คุณสมบัติผู้สมัคร</div>

        <div class="sub-form">

          <div class="sub-form-inner">

            <div class="form-row">
              <?php 
                echo Form::label('nationality', 'สัญชาติ', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'สัญชาติ',
                  'autocomplete' => 'off'
                ));
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('nationality', 'อายุ', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'อายุ',
                  'autocomplete' => 'off'
                ));
                echo '<p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น มากกว่า 25 ปี หรือ 25 - 30 ปี</p>';
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('nationality', 'เพศ', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'เพศ',
                  'autocomplete' => 'off'
                ));
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('nationality', 'ระดับการศึกษา', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'ระดับการศึกษา',
                  'autocomplete' => 'off'
                ));
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('nationality', 'ประสบการณ์การทำงาน', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'ประสบการณ์การทำงาน',
                  'autocomplete' => 'off'
                ));
                echo '<p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น 3ปีขึ้นไป หรือ 0 - 3 ปี</p>';
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('nationality', 'จำนวนที่รับ', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'จำนวนที่รับ',
                  'autocomplete' => 'off'
                ));
              ?>
            </div>

          </div>
        
        </div>

      </div>

      <div class="form-row">
        <?php 
          echo Form::label('description', 'รายละเอียดงาน', array(
            'class' => 'required'
          ));
          echo Form::textarea('description', null, array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('description', 'สวัสดิการ', array(
            'class' => 'required'
          ));
          echo Form::textarea('description', null, array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php echo Form::label('', 'รูปภาพสถานที่ทำงาน (สูงสุด 5 รูป)'); ?>
        <p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
        <p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
        <div id="_image_group">
        </div>
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
          echo Form::label('categories', 'แท๊ก (เช่น เสื้อยืด, โทนเนอร์, โคมไฟ, อาหารญี่ปุ่น)');
        ?>
        <div id="tags" class="tag"></div>
        <p class="notice info">แท็กจะช่วยให้การค้นหาโฆษณาของคุณง่ายขึ้น</p>
      </div>

    </div>

  </div>

  <div>
    ข้อมูลบริษัท
    จะต้องการข้อมูลของบริษัทของคุณอยางน้อย 1 บริษัท
    - ชื่อบริษัท
    - ประเภทธุรกิจ
    - ข้อมูลบริษัท
    - ข้อมูลการติดต่อ
    -- tel
    -- website
    -- fb
    -- line
    - ตำแหน่งที่ตั้ง
    -- จังหวัด
    -- อำเภอ
    -- ตำบล
    -- ระบุตำแหน่งบนแผนที่
  </div>

  <?php
    echo Form::submit('ลงประกาศงาน', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    Tag.load();
    Images.load();
    District.load();
  });
</script>

<script type="text/javascript" src="{{ URL::asset('js/map/map.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places&callback=initAutocomplete"
     async defer></script>

@stop