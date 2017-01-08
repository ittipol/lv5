@extends('layouts.default')
@section('content')
<div class="login-form">
	<div class="login-form-inner">
		<h2><a class="logo" href="{{URL::to('/')}}">CHONBURI SQUARE</a></h2>
		<!-- <h3>เข้าสู่ระบบ</h3> -->

		<?php if(!empty($errors->all())): ?>
			<?php foreach ($errors->all() as $message) { ?>
				<h4 class="error-message"><?php echo $message; ?></h4>
			<?php	} ?>
		<?php endif; ?>

		<div class="login-form-main">

			<?php
				echo Form::open(['method' => 'post', 'id' => 'login_form']);
			?>

			<div class="form-row">
				<?php 
					echo Form::label('email', 'อีเมล');
					echo Form::text('email', null, array(
						'placeholder' => 'อีเมล',
						'autocomplete' => 'off'
					));
				?>
			</div>

			<div class="form-row">
				<?php 
					echo Form::label('password', 'รหัสผ่าน');
					echo Form::password('password', null, array(
						'placeholder' => 'รหัสผ่าน',
						'autocomplete' => 'off'
					));
				?>
			</div>

			<div class="form-row">
				<?php
					echo Form::checkbox('remember', 1);
					echo Form::label('remember', 'จดจำฉันไว้ในระบบ');
				?>
			</div>

			<div>
				<?php
					echo Form::submit('เข้าสู่ระบบ', array(
						'class' => 'button wide-btn'
					));
				?>
			</div>

			<div>
				<a href="">ลืมรหัสผ่าน</a>
			</div>

			<div class="line space-top-bottom-10"></div>

			<a href="#" class="fb-button">
				<img src="/images/common/fb-logo.png">
				เข้าสู่ระบบด้วย Facebook
			</a>

			<div class="line space-top-bottom-10"></div>

			<a href="{{URL::to('register')}}" class="button wide-btn success">สมัครสมาชิก</a>

			<?php
				echo Form::close();
			?>
		</div>
</div>
@stop