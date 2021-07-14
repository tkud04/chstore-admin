<?php 
		 
  $name = $data['customer'];
  $subject = "New update on your order ".$data['reference'];
  $t = $data['t'];
  $statuses = $data['statuses'];
  $ts = $statuses[$t['status']];
?>

<center><img src="https://mobilebuzzonline.co.uk/images/youtube_profile_image.png" width="150" height="150"/></center>
<h3 style="background: #be831d; color: #fff; padding: 10px 15px;"><?php echo e($subject); ?></h3>
Hello <em><?php echo e($name); ?></em>,<br><br> you have a new update for your order:<br><br>
Date added: <?php echo e($t['date']); ?><br>
Status: <b><?php echo e(strtoupper($ts)); ?></b><br>
Comment: <em><?php echo e($t['comment']); ?></em>
<?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/emails/order-update.blade.php ENDPATH**/ ?>