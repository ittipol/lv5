@extends('layouts.default')
@section('content')
	<div class="container">
		<h1>สมัครสมาชิก</h1>

		<?php if(!empty($errors->all())): ?>
			<div class="form-error-messages">
				<div class="form-error-messages-inner">
					<h3>เกิดข้อผิดพลาด!!!</h3>
						<ul>
						<?php foreach ($errors->all() as $message) { ?>
							<li class="error-messages"><?php echo $message; ?></li>
						<?php	} ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>

		<?php
			echo Form::open(['url' => 'register', 'method' => 'post', 'enctype' => 'multipart/form-data']);
		?>

		<div class="form-row">
			<?php
		  	echo Form::label('avatar', 'รูปประจำตัว');
			?>
			<p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
			<p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
			
			<label class="image-label">
		    <?php
			    echo Form::file('avatar', array(
			    	'class' => 'avatar', 
			    	'id' => 'avatar'
			    ));
		    ?>
		    <img class="preview-image" src="images/avatar.png">
		    <a href="javscript:void(0);" class="avatar-remove" >×</a>
			</label>
			<p class="error-message"></p>
		</div>

		<div class="form-row">
			<?php 
				echo Form::label('name', 'ซื่อ', array(
					'class' => 'required'
				));
				echo Form::text('name', null, array(
					'placeholder' => 'ซื่อ',
					'autocomplete' => 'off'
				));
			?>
		</div>

		<div class="form-row">
			<?php 
				echo Form::label('email', 'อีเมล', array(
					'class' => 'required'
				));
				echo Form::text('email', null, array(
					'placeholder' => 'อีเมล',
					'autocomplete' => 'off'
				));
			?>
		</div>

		<div class="form-row">
			<?php 
				echo Form::label('password', 'รหัสผ่าน', array(
					'class' => 'required'
				));
				echo Form::password('password', null);
			?>
			<p class="notice info">อย่างน้อย 4 อักขระ</p>
		</div>

		<div class="form-row">
			<?php 
				echo Form::label('password_confirmation', 'ป้อนรหัสผ่านอีกครั้ง', array(
					'class' => 'required'
				));
				echo Form::password('password_confirmation', null);
			?>
		</div>

		<div class="form-row">
			<div class="select-group">
				<?php 
					echo Form::label('', 'วันเกิด');
					echo Form::select('birth_day', $day, null, array(
						'id' => 'birth_day'
					));
					echo Form::select('birth_month', $month, null, array(
						'id' => 'birth_month'
					));
					echo Form::select('birth_year', $year, null, array(
						'id' => 'birth_year'
					));
				?>
			</div>
			<p class="notice info">วันเกิดจะช่วยให้เรานำเสนอสิ่งต่างๆ ให้เหมาะสมกับคุณมากขึ้น</p>
		</div>

		<div class="form-row">
			<?php 
				echo Form::label('gender', 'เพศ');
				echo Form::select('gender', array(
					'm' => 'ชาย',
					'f' => 'หญิง',
					'0' => 'ไม่ระบุ'
				));
			?>
		</div>

		<div class="form-row">
			<?php 
				echo Form::label('tags', 'สิ่งที่คุณสนใจ (เช่น รองเท้า, อาหารเสริม, คอมพิวเตอร์, กล้อง)');
			?>
			<p class="error-message">* สามารถเพิ่ม หรือ แก้ไขได้ในภายหลัง</p>
			<div id="tags" class="tag"></div>
			<p class="notice info">สิ่งที่คุณสนใจจะช่วยให้ระบบสามารถแสดงข้อมูลต่างๆ ที่ตรงกับความต้องการของคุณ</p>
		</div>

		<div class="form-row">
			<?php
				echo Form::checkbox('receive_email', 1);
				echo Form::label('receive_email', 'รับข่าวสารหรือข้อเสนิพิเศษ คุณสามารถยกเลิกการสมัครได้ทุกเมื่อ');
			?>
		</div>

		<?php
			echo Form::submit('สมัครสมาชิก', array(
				'class' => 'button'
			));
		?>

		<?php
			echo Form::close();
		?>

		<script type="text/javascript">

			var Avatar = {}

			Avatar.load = function(){
				Avatar.bind();
			}

			Avatar.bind = function(){

				$(document).on('change', '.avatar', function(){
					Avatar.preview(this);
				});

				$(document).on('click', '.avatar-remove', function(){
					Avatar.removePreview(this);
				});
				
			}

			Avatar.preview = function(input){
				
				if (input.files && input.files[0] && Avatar.checkImageType(input.files[0]['type']) && Avatar.checkImageSize(input.files[0]['size'])) {
			    var reader = new FileReader();

			    reader.onload = function (e) {
			    	var parent = $(input).parent();
			    	parent.find('a').css('display','block');
			    	parent.find('img').css('display','block').attr('src', e.target.result);
			    }

			    reader.readAsDataURL(input.files[0]);
				
			    $("#avatar_error").text('');

				}else{
					$("#avatar_error").text('ไม่รองรับรูปภาพนี้');
				}
			}

			Avatar.removePreview = function(input){
				var parent = $(input).parent();
				parent.find('a').css('display','none');
				parent.find('img').css('display','block').attr('src', 'images/avatar.png');
				parent.find('input').val('');
			}

			Avatar.checkImageType = function(type){
				var acceptedType = ['image/jpg','image/jpeg','image/png'];

				var accepted = false;

				for (var i = 0; i < acceptedType.length; i++) {
					if(type == acceptedType[i]){
						accepted = true;
						break;						
					}
				};

				return accepted;
			}

			Avatar.checkImageSize = function(size) {
				// 3MB
				var maxSize = 3145728;

				var accepted = false;

				if(size <= maxSize){
					accepted = true;
				}

				return accepted;

			}

			$(document).ready(function(){
				Avatar.load();
				Tag.placeholder = 'สิ่งที่คุณสนใจ';
				Tag.dataName = 'interests';
				Tag.load();
			});

		</script>

@stop