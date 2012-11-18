<?php
include('settings/settings.php');
include('helpers/helper.php');

$objSession = new Session();
//printArray($objSession);
//exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/lib/jquery.js"></script>
<script src="js/modernizr.js"></script>
<!--[if IE 6]>
<link href="css/IE/style-IE-6.css" rel="stylesheet" type="text/css">
<script>
$(document).ready(function() {
    $('#logo-img').attr('src','css/IE/images-IE-6/logo.jpg');
    $('#fb-btn-img').attr('src','css/IE/images-IE-6/fb.png');
});
</script>
<![endif]-->

<!--[if IE 7]>
<link href="css/IE/style-IE-7.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8]>
<link href="css/IE/style-IE-8.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/border_rounded.js"></script>
<script>
$(document).ready(function() {
    $('.big-btn').corner();
});
</script> -->

</head>

<body>
<div id="warpper">
  <?php include('includes/header.php');?>
  <div id="content">
    <div id="heading-text">
      <h1 class="create-account"> Create An Account </h1>
      <h4 class="create-account-text"> You Just Have to Select Your Category and Create a New Account </h4>
    </div>
    <div id="signin-btn">
      <div id="expert" class="big-btn" onClick="window.location.href='expform.php'">
        <div class="btn-text expert-text"> <a href="expform.php"> I am an Expert </a> </div>
      </div>
      <div id="prm" class="big-btn" onClick="window.location.href='prmform.php'">
        <div class="btn-text prm-text"> <a href="prmform.php"> I am a Public Relations Manager </a> </div>
      </div>
      <div id="advertiser" class="big-btn" onClick="window.location.href='advform.php'">
        <div class="btn-text advertiser-text"> <a href="advform.php"> I am an Advertiser </a> </div>
      </div>
      <div id="media" class="big-btn" onClick="window.location.href='mform.php'">
        <div class="btn-text media-text"> <a href="mform.php"> I am with the Media </a> </div>
      </div>
    </div>
  </div>
  <!-- content --> 
  
  <!-- footer -->
  <?php include('includes/footer.php');?>
  <!-- footer --> 
  
</div>
<!-- Warpper -->

</body>
</html>
