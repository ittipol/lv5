<!doctype html>
<html>
<head>
  <!-- Meta data -->
  @include('includes.meta') 
  <!-- CSS & JS -->
  @include('includes.script')
  <!-- Title  -->
  <title>Chonburi Square</title>
</head>
<body>

  <main>
    @include('layouts.blackbox.wrapper')
  </main>

  <script type="text/javascript">

    $(document).ready(function(){
      const additionalOption = new AdditionalOption();
      additionalOption.load();

      const blackbox = new Blackbox;
      blackbox.load();

      setTimeout(function(){
        $(".nano").nanoScroller();
      },1000);
    });
    
  </script>

  @if (!Auth::check())

    <script type="text/javascript">
      $(document).ready(function(){
        let title = 'เข้าถึงเนื้อหาทั้งหมดและบริษัทหรือร้านค้าด้วยการเข้าสู่ระบบ';
        let desc = '';
        desc += '<div class="button-group">';
        desc += '<a class="button" href="login">เข้าสู่ระบบ</a>';
        desc += '<a class="button" href="select_registation">สมัครสมาชิก</a>';
        desc += '</div>';

        const notificationBottom = new NotificationBottom(title,desc,'','medium',true);
        notificationBottom.load();
      });
    </script>
  @endif

</body>
</html>