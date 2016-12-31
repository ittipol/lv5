<div class="action-bar">
  <div class="contain-fluid">
    <div class="row">
      <div class="col-lg-3">
        <ul class="action-bar-nav">
          <li class="icon">
            <!-- <a id="hamburger_menu_trigger" href="javascript:void(0);">&#9776;</a> -->
            <label for="hamburger_menu_trigger">
              &#9776;
              <input type="checkbox" id="hamburger_menu_trigger" class="nav-trigger" style="display:none;" />
            </label>
          </li>
        </ul>
        <div class="action-bar-text pull-left">
          <a class="link" href="{{URL::to('/')}}">Go-Go shop</a>
        </div>
      </div>
      <div class="col-lg-9">
        <nav class="pull-right">
          <a class="avatar" href="{{URL::to('user/account')}}"><img src="/avatar" /></a>
        </nav>
      </div>
    </div>
  </div>
</div>