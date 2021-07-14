<?php 
		 
  $name = $data['customer'];
  $subject = "New update on your order ".$data['reference'];
  $t = $data['t'];
  $statuses = $data['statuses'];
  $ts = $statuses[$t['status']];
?>

<center><img src="https://mobilebuzzonline.co.uk/images/youtube_profile_image.png" width="150" height="150"/></center>
<h3 style="background: #be831d; color: #fff; padding: 10px 15px;">{{$subject}}</h3>
Hello <em>{{$name}}</em>,<br><br> you have a new update for your order:<br><br>
Date added: {{$t['date']}}<br>
Status: <b>{{strtoupper($ts)}}</b><br>
Comment: <em>{{$t['comment']}}</em>
