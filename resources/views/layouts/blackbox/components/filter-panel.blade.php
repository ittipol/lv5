<div class="clearfix">
  <label class="filter-icon pull-right" for="filter_panel_trigger">
    <img src="/images/icons/sort.png">
    <input type="checkbox" id="filter_panel_trigger" class="filter-panel-trigger" />
  </label>
</div>


  <div class="filter-panel nano">
    <div class="nano-content">
      <div class="filter-panel-inner">
        <h5>เรียง</h5>
        <div class="line"></div>
        <ul class="nav-stack-item ">
          <li class="item">
            <a class="active" href="{{URL::to('list/')}}">ตัวอักษร A - Z ก - ฮ</a>
          </li>
          <li class="item">
            <a href="{{URL::to('list/')}}">ตัวอักษร Z - A ฮ - ก</a>
          </li>
          <li class="item">
            <a href="{{URL::to('list/')}}">เพิ่มล่าสุด</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
