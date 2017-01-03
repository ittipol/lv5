<!-- @if (!Auth::check())
<li><a href="{{URL::to('login')}}">เข้าสู่ระบบ</a></li>
<li><a href="{{URL::to('register')}}">สมัครสมาชิก</a></li>
@else
<li>
  <a href="{{URL::to('user/account')}}"><img class="avatar" src="/avatar" /></a>
</li>
<li><a href="{{URL::to('user/account')}}">{{Session::get('Person.Profile.name')}}</a><li>
<li><a href="{{URL::to('logout')}}">ออกจากระบบ</a><li>
@endif -->
<div class="main-navigation">
  <nav>
    <div class="navigation-top">

      <!-- <div class="logo">
        <a class="logo-link" href="{{URL::to('/')}}">Chonburi Square</a>
      </div> -->

      @if (!Auth::check())

        <div class="account-info">
          <div>คุญยังไม่ได้เข้าสู่ระบบ</div>
          <div class="account-description">
            <a href="{{URL::to('login')}}">
              <h4>เข้าสู่ระบบ</h4>
            </a>
          </div>
        </div>
        <div class="line space-top-bottom-10"></div>
        <div class="account-info">
          <div>หรือคุณยังไม่มีบัญชี</div>
          <div class="account-description">
            <a href="{{URL::to('select_registation')}}">
              <h4>สมัครสมาชิก</h4>
            </a>
          </div>
        </div>
        <div class="line space-top-bottom-10"></div>

      @else

        <div class="account-info clearfix">
          <a class="avatar pull-left" href="{{URL::to('user/account')}}">
            <img src="/avatar" />
          </a>
          <div class="account-description pull-left">
            <div>{{Session::get('Person.Profile.name')}}</div>
            <div><a class="avatar pull-left" href="{{URL::to('user/account')}}">จัดการบัญชี</a></div>
          </div>
          <div class="additional-option">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{URL::to('logout')}}">ออกจากระบบ</a>
            </div>
          </div>
        </div>

      @endif

    </div>

    <div class="navigation-primary-menu">
      <div class="nano">
        <ul class="nav-stack-item nano-content">

          <li class="item">
            <a href="{{URL::to('/')}}">หน้าแรก</a>
          </li>
          <li class="item">
            <a href="{{URL::to('/')}}">Wiki ชลบุรี</a>
          </li>

          @if (Auth::check())

            <li class="line space-top-bottom-10"></li>
            <li class="item">
              <a href="{{URL::to('entity/create')}}">เพิ่ม</a>
              <div class="additional-option">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="additional-option-content">
                  <a href="javascript:void(0);">เรียนรู้เพิ่มเติม</a>
                </div>
              </div>
              <ul class="submenu">
                <li class="submenu-item">
                  <a href="{{URL::to('online-shop/add')}}">ร้านค้าออนไลน์</a>
                  <a href="{{URL::to('company/add')}}">บริษัทหรือร้านค้าของคุณ</a>
                </li>
              </ul>
            </li>
            <li class="line space-top-bottom-10"></li>
            <li class="item">
              <a href="{{URL::to('entity/create')}}">สินค้าแนะนำ</a>
            </li>
            <li class="item">
              <a href="{{URL::to('entity/create')}}">งานที่คุณกำลังค้นหา</a>
            </li>
            <li class="line space-top-bottom-10"></li>
            <li class="item">
              <a href="{{URL::to('entity/create')}}">ตั้งค่า</a>
            </li>
            <li class="item">
              <a href="{{URL::to('entity/create')}}">ข้อเสนอแนะ</a>
            </li>
            <li class="item">
              <a href="{{URL::to('entity/create')}}">ติดต่อเรา</a>
            </li>

          @endif
        </ul>
      </div>
    </div>
  </nav>
</div>
