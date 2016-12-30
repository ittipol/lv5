<nav>
  <div class="navigation-top">
    <div class="logo">
      <a class="logo-link" href="{{URL::to('/')}}">Chonburi Square</a>
    </div>
  </div>
  <div class="navigation-primary-menu">
    <ul class="nav-stack-item">
      <li class="item">
        <a href="{{URL::to('/')}}">หน้าแรก</a>
      </li>
      <li class="item">
        <span>
          <a href="{{URL::to('entity/create')}}">เพิ่ม</a>
          <div class="additional-option horizon">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
          </div>
          <div class="additional-option-items">
            <a href="javascript:void(0);">แสดงแผนก</a>
          </div>
        </span>
        <ul class="submenu">
          <li class="submenu-item">
            <a href="{{URL::to('online-shop/add')}}">ร้านค้าออนไลน์</a>
            <a href="{{URL::to('company/add')}}">บริษัทหรือร้านค้าของคุณของคุณ</a>
          </li>
        </ul>
      </li>
      <li class="item">
        <a href="{{URL::to('entity/create')}}">สินค้าแนะนำ</a>
      </li>
      <li class="item">
        <a href="{{URL::to('entity/create')}}">งานที่คุณกำลังค้นหา</a>
      </li>
    </ul>
  </div>
</nav>
