@extends('layouts.blackbox.main')
@section('content')
  <div class="entity-panel">

    <div class="entity-header" style="background-image: url('/images/xxx.jpg');">
        <div class="contain-fluid">
          <div class="entity-header-overlay">
            <div class="row">
              <div class="col-md-12 col-lg-9">
                <div class="entity-header-info clearfix">
                  <div class="entity-logo" style="background-image: url('<?php echo $logo ?>');"></div>
                  <section class="entity-description">
                    <h2><?php echo strip_tags($name); ?></h2>
                    <p><?php echo strip_tags($short_description); ?></p>
                  </section>
                </div>
              </div>
              <div class="col-md-12 col-lg-3">
                <div class="entity-header-action">

                  <button>ถูกใจร้านนี้</button>

                  <div>
                    <h3>สินค้าของคุณ</h3>
                    ติดตาม
                    ถูกใจ
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="entity-content">
      <div class="contain-fluid">

        <div>

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
        </div>

        <h3>งาน</h3>
        สามารถเลือกงานที่ต้องการแสดงได้ สูงสุด 10 งาน <br/>
        --> แสดงงานทั้งหมด <br/>


        สามารถเลือกได้ว่าต้องการให้งานแสดงก่อนหรือสินค้า
      </div>
    </div>
  </div>
@stop