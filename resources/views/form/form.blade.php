@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
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
    echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <?php
    // echo  Form::model($model->getAttributes(), [
    //   'id' => 'main_form',
    //   'method' => 'PATCH',
    //   'route' => ['form.edit', $model->id],
    //   'enctype' => 'multipart/form-data'
    // ]);
  ?>

  <?php
    echo Form::hidden('__token', $__token);
  ?>

  <!-- content here  -->
  @yield('form_content')

  <?php
    echo Form::close();
  ?>

</div>

@stop