<!doctype html>
<html>
<head>
<!-- my head section goes here -->
@include('includes.script') 

<link rel="stylesheet" href="{{ URL::asset('css/layouts/header.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/layouts/footer.css') }}" />

<title>Chonburi Square</title>
</head>
<body>
	<header> 
		<div class="banner-header">
			<div class="banner"></div>
			<div class="bg-overlay"></div>

			@include('layouts.default_header') 

			<div class="header-primary-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-7">
							<div class="primary-text">
								ร่วมสร้างชุมชนแห่งใหม่กับ Chonburi Square
							</div>
							<p class="secondary-text">ร่วมเป็นส่วนหนึ่งกับเราในการเพิ่มข้อมูลหรือรายละเอียดต่างๆ ของจังหวัดชลบุรี ไม่ว่าจะเป็น ร้านอาหาร สถานที่ท่องเที่ยว เทศกาล สินค้า ผลิตภัณฑ์ การบริการ หรือร้านค้าของคุณ ในจังหวัดชลบุรี เพื่อเป็นการโฆษณาและให้ข้อมูลกับนักท่องเที่ยวหรือคนในพื้นที่ที่ยังไม่ทราบรายละเอียดของสินค้าหรือสถานที่นั้นๆ
							</p>
							<br/>
							<div>
								<a href="{{URL::to('place/add')}}" class="button">ไปยังหน้าแรก</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main>
		@include('layouts.landing_content') 
  </main>
  <footer> 
  	@include('layouts.default_footer') 
  </footer>
</body>
</html>