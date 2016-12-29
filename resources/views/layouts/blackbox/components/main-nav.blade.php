<nav>
  <div class="navigation-top">
    <div class="logo">
      <a class="logo-link" href="{{URL::to('/')}}">Chonburi Square</a>
    </div>
  </div>
  <div class="navigation-primarymenu">
    <ul class="nav-stack-item">
      <li class="item">
        <a href="{{URL::to('company/add')}}">หน้าแรก</a>
      </li>
      <li class="item">
        <a href="{{URL::to('company/add')}}">เมนู 1</a>
        <ul class="submenu">
          <li class="submenu-item">
            <a href="{{URL::to('company/add')}}">เพิ่มร้านค้า</a>
          </li>
        </ul>
      </li>
      <li class="item"></li>
    </ul>
  </div>
</nav>
