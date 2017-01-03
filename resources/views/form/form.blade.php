@extends('layouts.blackbox.main')

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

  <?php
    echo Form::hidden('__token', $__token);
  ?>

  @section('content')

  @stop

  <?php
    echo Form::submit('เพิ่มสถานประกอบการหรือร้านค้าของคุณ', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

