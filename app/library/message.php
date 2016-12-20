<?php

namespace App\library;

use Auth;
use Session;

class Message
{
  public function registerSuccess() {
    Session::flash('message.title', 'ขอบคุณสำหรับการสมัครสมาชิก');
    Session::flash('message.desc', 'บัญชีของคุณพร้อมใช้งานได้แล้ว');
    Session::flash('message.type', 'success');
  }

  public function loginSuccess() {
    Session::flash('message.title', 'คุณเข้าสู่ระบบแล้ว');
    Session::flash('message.desc', '');
    Session::flash('message.type', 'info');
  } 

	public function loginRequest() {
	  Session::flash('message.title', 'กรุณาเข้าสู่ระบบ');
	  Session::flash('message.desc', 'หน้าที่คุณเรียกนั้น จำเป็นต้องเข้าสู่ระบบก่อนเพื่อการทำงานที่ถูกต้อง');
	  Session::flash('message.type', 'error');
	} 

  public function addingSuccess($subject = 'ข้อมูล') {
    Session::flash('message.title', $subject.'ถูกเพิ่มเรียบร้อยแล้ว');
    Session::flash('message.type', 'success');
  }

  public function editingSuccess($subject = 'ข้อมูล') {
    Session::flash('message.title', $subject.'ถูกแก้ไขเรียบร้อยแล้ว');
    Session::flash('message.type', 'success');
  }

  public function companyRequest() {
    Session::flash('message.title', 'คุณยังไม่ได้เพิ่มสถานประกอบการขอบคุณ');
    Session::flash('message.desc', 'กรุณาเพิ่มสถานประกอบการของคุณอย่างน้อย 1 สถานประกอบการ');
    Session::flash('message.type', 'error');
  } 

  public function companyCheckFail() {
    Session::flash('message.title', 'ไม่พบสถานประกอบการนี้ในระบบหรือคุณไม่ได้อยู่ในสถานประกอบการนี้');
    Session::flash('message.desc', 'กรุณาตรวจสอบรายชื่อสถานประกอบการของคุณ');
    Session::flash('message.type', 'error');
  }

  public function error($text = '') {
    Session::flash('message.title', 'เกิดข้อผิดพลาด!!! '.$text);
    Session::flash('message.type', 'error'); 
  }

}
