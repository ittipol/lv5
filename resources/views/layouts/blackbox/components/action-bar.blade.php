<div class="action-bar">
  <div class="contain-fluid">
    <div class="row">
      <div class="col-lg-3">
        <div class="action-bar-logo pull-left">
          <a class="logo-link" href="{{URL::to('/')}}">Chonburi Square</a>
        </div>
      </div>
      <div class="col-lg-9">
        <nav class="pull-right">

          <a class="avatar" href="{{URL::to('user/account')}}"><img src="/avatar" /></a>
          <ul class="action-bar-nav">
            <li><a href="#home">{{Session::get('Person.Profile.name')}}</a></li>
            <li><a href="{{URL::to('logout')}}">ออกจากระบบ</a></li>
            <li><a href="#contact">Feedback</a></li>
            <li><a href="#about">Contact us</a></li>
            <li class="icon">
              <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
            </li>
          </ul>
          <!-- <ul class="nav navbar-nav">
            @if (!Auth::check())
            <li><a href="{{URL::to('login')}}">เข้าสู่ระบบ</a></li>
            <li><a href="{{URL::to('register')}}">สมัครสมาชิก</a></li>
            @else
            <li>
              <a href="{{URL::to('user/account')}}"><img class="avatar" src="/avatar" /></a>
            </li>
            <li><a href="{{URL::to('user/account')}}">{{Session::get('Person.Profile.name')}}</a><li>
            <li><a href="{{URL::to('logout')}}">ออกจากระบบ</a><li>
            @endif
            <li><a href="#">Feedback</a></li> 
            <li><a href="#">Contact us</a></li> 
          </ul> -->
        </nav>
      </div>
    </div>
  </div>
</div>