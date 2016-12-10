var NotificationBottom = {
	title: '',
	desc: '',
	error: '',
  delay: 9000,
}

NotificationBottom.load = function() {
	NotificationBottom.init();
	NotificationBottom.bind();
}

NotificationBottom.init = function() {
	NotificationBottom.displayNotification()
}

NotificationBottom.bind = function() {
	$('#notification_bottom_close').on('click', function(){
		$('#notification_bottom').stop().fadeOut(220)
	});
}

NotificationBottom.createNotification = function() {

	html = '';
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

  html = html.replace('{{title}}',NotificationBottom.title);
  html = html.replace('{{desc}}',NotificationBottom.desc);
  html = html.replace('{{type}}',NotificationBottom.type);

  return html;

}

NotificationBottom.displayNotification = function() {

	$('#notification_bottom').remove();	
  $('body').append(NotificationBottom.createNotification());

  document.getElementById('notification_bottom').style.opacity = 0;
  document.getElementById('notification_bottom').style.bottom = -document.getElementById('notification_bottom').offsetHeight+'px';

  $('#notification_bottom').animate({bottom:0,opacity:1},500,'swing').delay(NotificationBottom.delay).fadeOut(220);

}



