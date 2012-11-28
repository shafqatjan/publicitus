<?php 
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(CLIENT_ROLE_ADVERTISER);
$objSession->checkSession(CLIENT_ROLE_ADVERTISER,"../index.php") ;

$objDb =new Database();
$objDb->connect();
$objCal = new Calander();
$sqlCal = $objCal->PopulateGrid("*",' AND status=1 AND user_id='.$objSession->id);
$catArray = $objDb->getArray($sqlCal);
//printArray($catArray);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/modernizr.js"></script>
<!--[if IE 6]>
<link href="../css/IE/style-IE-6.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 7]>
<link href="../css/IE/style-IE-7.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8]>
<link href="../css/IE/style-IE-8.css" rel="stylesheet" type="text/css">
<![endif]-->

<style type="text/css">
.calDay-callendar {
     float: left;
    height: 20px;
    line-height: 0;
    margin: 16px 0 0 21px;
    text-align: center;
    width: 60px;
}
.calPlus-callendar {
      float: right;
    height: 15px;
    line-height: 0;
    margin: 8px 2px 0 0;
    width: 20px;
}
.light-callendar {
    background: none repeat scroll 0 0 F4F4F4;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
}
</style>


</head>

<body>

<div id="warpper">
  <?php include('../includes/header.php');?>
  <div id="content" style="margin:4% 0% 0% -8%">
    <form method="post" action="">
       <input type="hidden" name="userType" id="userType" value="1">
      <div id="form-warrper">
      <?php include("../includes/err-succ-info.php");  ?>
	 
        <div class="form-head">
          <h3> Basic Information </h3>
        </div>
        <div style="clear:both"></div>
        <?php include("../includes/calender.php");  ?>
   </div> <!-- form warrper -->
  </form>
  </div> <!-- content -->
  
  <!-- footer -->
    <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
<?=$objDb->close();?>