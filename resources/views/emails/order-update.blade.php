<?php 
		 
  $name = $data['customer'];
  $subject = "New update on your order ".$data['reference'];;
  $msg = $data['message'];
  $dept = "Unspecified";
  $ts = $statuses[$t['status']];
?>

<center><img src="http://etukng.tobi-demos.tk/img/etukng.png" width="150" height="100"/></center>
<h3 style="background: #be831d; color: #fff; padding: 10px 15px;">{{$subject}}</h3>
Hello <em>{{$name}}</em>,<br><br> you have a new update for your order:<br><br>
Date added: {{$t['date']}}<br>
Status: <b>{{strtoupper($ts)}}</b><br>
Comment: <em>{{$t['comment']}}</em>
