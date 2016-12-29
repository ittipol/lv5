class NotificationBottom {
  constructor(title = '',desc = '',type = '') {
      this.title = title;
      this.desc = desc;
      // this.error = '';
      this.type = type;
      this.delay = 9000;
  }

  load() {
    this.init();
    this.bind();
  }

  init() {
    this.displayNotification()
  }

  bind() {
    $('#notification_bottom_close').on('click', function(){
      $('#notification_bottom').stop().fadeOut(220)
    });
  }

  createNotification() {

    let html = '';
    html += '<div id="notification_bottom" class="notification-bottom {{type}}">';
    html += '<div class="notification-bottom-inner">';
    html += '<div class="container">';
    html += '<div class="message">';
    html += '<div class="title">{{title}}</div>';
    html += '<p class="description">{{desc}}</p>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '<div id="notification_bottom_close" class="close-btn">×</div>';
    html += '</div>';

    html = html.replace('{{title}}',this.title);
    html = html.replace('{{desc}}',this.desc);
    html = html.replace('{{type}}',this.type);

    return html;

  }

  displayNotification() {

    $('#notification_bottom').remove(); 
    $('body').append(this.createNotification());

    document.getElementById('notification_bottom').style.opacity = 0;
    document.getElementById('notification_bottom').style.bottom = -document.getElementById('notification_bottom').offsetHeight+'px';

    $('#notification_bottom').animate({bottom:0,opacity:1},500,'swing').delay(this.delay).fadeOut(220);

  }
}