@extends('entity.layout.default')
@section('entity_content')
  <div class="entity-panel">

    <div class="entity-header entity-default-cover">
      <div class="entity-cover" style="background-image: url('<?php echo $cover ?>');"></div>
      <div class="contain-fluid">
        <div class="entity-header-overlay clearfix">
          <div class="row">
            <div class="col-md-12 col-lg-9">
              <div class="entity-header-info clearfix">
                <div class="entity-logo">
                  <div class="logo" style="background-image: url('<?php echo $logo ?>');"></div>
                </div>
                <section class="entity-description">
                  <h2><?php echo $entity['info']['name']; ?></h2>
                  <p><?php echo $entity['info']['short_description']; ?></p>
                </section>
              </div>
            </div>
            <div class="col-md-12 col-lg-3">
              <div class="entity-header-secondary-info">

                <div class="additional-option triangle working-time-status <?php echo $entity['OfficeHour']['status']['name']; ?>">
                  <?php echo $entity['OfficeHour']['status']['text']; ?>
                  <div class="additional-option-content">
                    <?php foreach ($entity['OfficeHour']['workingTime'] as $workingTime): ?>
                    <span><?php echo $workingTime['day'].' '.$workingTime['workingTime']; ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="line space-top-bottom-20"></div>

                <div class="entity-info">
                  <h4>ที่อยู่</h4>
                  <div>
                    <?php echo $entity['Address']['fullAddress'];  ?>
                  </div>
                </div>

                <div class="line space-top-bottom-20"></div>

                <a href="{{URL::to('story/add')}}" class="button">ถูกใจ</a>
                <a href="{{URL::to('story/add')}}" class="button">ติดตาม</a>

                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary">ถูกใจ</button>
                  <button type="button" class="btn btn-secondary">ติดตาม</button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="entity-content">
      <div class="contain-fluid">



        <div class='entity-right-side-panel'>

          <div>เวลาทำการ</div>
          <div class="line"></div>

          <?php 
            foreach ($entity['OfficeHour']['workingTime'] as $workingTime):
          ?>
            <div><?php echo $workingTime['day'].' '.$workingTime['workingTime']; ?></div>
          <?php endforeach; ?>
        </div>

        <div id="entity_left_panel" class="entity-left-panel">

          <div class="entity-main-bar">
            <div class="row">
              <div class="col-lg-6  col-md-12">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary">สินค้า</button>
                  <button type="button" class="btn btn-secondary">โฆษณา</button>
                  <button type="button" class="btn btn-secondary">ประกาศงาน</button>
                  <button type="button" class="btn btn-secondary">กิจกรรม</button>
                  <button type="button" class="btn btn-secondary">เพิ่ม...</button>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary">เพิ่ม...</button>
                </div>
              </div>
            </div>
          </div>

          <h3>ปรับแต่งหน้าแรก</h3>

          <div class="main-content">
            <h2>เขียนข้อความถึงลูกค้า</h2>
            <h3>ข้อความนี้จะแสดงตลอดเวลาในหน้านี้</h3>
            <div>รายละเอียด feature เป็นหัวข้อ</div>
          </div>

          <h1>image description</h1>
          <h1>แยกเป็นอีกระบบ ขายของมือ2</h1>

          <h1>หัวข้อ ปรับแต่งร้านค้าของคุณ</h1>

          <h1>right bar เหมือน filter ไว้แสดงข้อมูลต่างๆ เช่น หมวดหมู่, tags , tel และอื่น ดูจาก wongnai</h1>

          <h3>new function</h3>
          ระบบค้นหาสินค้าเฉพาะใน shop นี้

          <h3>โฆษณา (ขึ้นก่อน (ถ้ามี))</h3>
          สามารถเลือกโฆษณาที่ต้องการแสดงได้ สูงสุด 10 โฆษณา <br/>
          --> แสดงโฆษณาทั้งหมด <br/>

          <h3>สินค้าของคุณ</h3>

          สร้างกลุ่มของผลิตภัณฑ์

          --------------------- <br/>
          -> สินค้าแนะนำ <br/>
          ----> แสดง 10 ชื้น <br/>
          -> สินค้าใหม่ <br/>
          ----> แสดง 5 ชื้น <br/>
          -> หมวดหมู่แนะนำ <br/>
          ----> แสดงหมวดหมู่ 3 หมวดหมู่ พร้อมสินค้าล่าสุด 6 ชิ้น <br/>
          --> แสดงหมวดหมู่ทั้งหมด <br/>
          --> แสดงสินค้าทั้งหมด <br/>
          --------------------- <br/>


          สามารถเลือกสินค้าที่ต้องการแนะนำได้มากสุด 15 ชิ้น
          สร้างหมวดหมู่สินค้าของคุณ
          สร้างหมวดหมู่วินค้าได้ จะทำให้ถูกเก็บอยู่ในหมวดหมู่นั้น คุณสามารถเลือกแนะนำหมวดหมู่ที่คุณคุณต้องการให้ลูกค้าเห็นมากที่สุดเมื่อเข้ามายังร้านค้าของคุณ
        
          <h3>งาน</h3>
          สามารถเลือกงานที่ต้องการแสดงได้ สูงสุด 10 งาน <br/>
          --> แสดงงานทั้งหมด <br/>


          สามารถเลือกได้ว่าต้องการให้งานแสดงก่อนหรือสินค้า

        </div>

      </div>
    </div>
  </div>
@stop