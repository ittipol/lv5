@extends('layouts.blackbox.main')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places"></script>

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          <?php echo $form['textHeader']; ?>
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
    if($action == 'add') {
      echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
    }elseif($action == 'edit') { 
      echo  Form::model([], [
        'id' => 'main_form',
        'method' => 'PATCH',
        'route' => ['form.edit', $entity['slugName'],
        'enctype' => 'multipart/form-data'
      ]);
    }
    
  ?>

  <?php
    echo Form::hidden('__token', $__token);
  ?>

  @yield('form_content')

  <?php
    echo Form::submit($form['textButton'] , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

@stop