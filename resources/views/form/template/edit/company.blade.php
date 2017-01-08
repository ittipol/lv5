@extends('form.layout.default')
@section('form_content')

  <div class="form-section">

    <div class="title">
      ข้อมูลร้านค้าหรือสถานประกอบการ
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('business_entity_id', 'รูปแบบธุรกิจ');
          echo Form::select('business_entity_id', $businessEntities ,$company['business_entity_id']);
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('business_type', 'ประเภทธุรกิจ');
          echo Form::text('business_type', $company['business_type'], array(
            'placeholder' => 'ประเภทธุรกิจ',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">เช่น ก่อสร้าง, การขนส่ง, ไอที</p>
        <p class="notice info">ประเภทธุรกิจจะมีผลโดยตรงต่อการค้นหา</p>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('brand_story', 'Brand Story');
          echo Form::textarea('brand_story', $company['brand_story'], array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('description', 'รายละเอียดเพิ่มเติม');
          echo Form::textarea('description', $company['description'], array(
            'class' => 'ckeditor'
          ));
        ?>
      </div>

      <div class="form-row">

        <div class="sub-title">เวลาทำการ</div>

        <div class="sub-form">

          <div class="sub-form-inner">

            <div class="form-row">
              <?php 
                echo Form::checkbox('OfficeHour[same_time]', 1, $sameTime, array(
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
        echo Form::text('Contact[phone_number]', $contact['phone_number'], array(
          'placeholder' => 'เบอร์โทรศัพท์',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[website]', 'เว็บไซต์');
        echo Form::text('Contact[website]', $contact['website'], array(
          'placeholder' => 'เว็บไซต์',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[email]', 'อีเมล');
        echo Form::text('Contact[email]', $contact['email'], array(
          'placeholder' => 'อีเมล',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[facebook]', 'Facebook');
        echo Form::text('Contact[facebook]', $contact['facebook'], array(
          'placeholder' => 'Facebook',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[instagram]', 'Instagram');
        echo Form::text('Contact[instagram]', $contact['instagram'], array(
          'placeholder' => 'Instagram',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[line]', 'Line');
        echo Form::text('Contact[line]', $contact['line'], array(
          'placeholder' => 'Line',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ที่อยู่ร้านค้าหรือสถานประกอบการ
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('Address[address]', 'ที่อยู่');
          echo Form::textarea('Address[address]', $address['address'], array(
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
          echo Form::select('Address[district_id]', $districts ,$address['district_id'], array(
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
        <?php echo Form::label('', 'ระบุตำแหน่งร้านค้าหรือสถานประกอบการบนแผนที่'); ?>
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
          echo Form::label('_tags', 'แท๊กที่เกี่ยวข้องกับร้านค้าหรือสถานประกอบการของคุณ');
        ?>
        <div id="_tags" class="tag"></div>
        <p class="notice info">แท็กจะช่วยให้การค้นหาร้านค้าหรือสถานประกอบการของคุณง่ายขึ้น</p>
      </div>

    </div>

  </div>

  <script type="text/javascript">

    $(document).ready(function(){
      
      const tagging = new Tagging();
      tagging.load('<?php echo $taggings; ?>');

      const district = new District();
      district.load('<?php echo $address['sub_district_id']; ?>');

      const map = new Map();
      map.load('<?php echo $geographic; ?>');

      const officeHour = new OfficeHour();
      officeHour.load('<?php echo $officeHour; ?>','<?php echo $sameTime; ?>');

      const form = new Form()
      form.load();

    });

  </script>

@stop