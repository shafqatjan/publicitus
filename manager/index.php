<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_MANAGER);
$objSession->checkSession(CLIENT_ROLE_MANAGER,"../index.php") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/modernizr.js"></script>
<!--[if IE 6]>
<link href="css/IE/style-IE-6.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 7]>
<link href="css/IE/style-IE-7.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8]>
<link href="css/IE/style-IE-8.css" rel="stylesheet" type="text/css">
<![endif]-->

</head>

<body>

 <div id="warpper">
 
  <?php include('../includes/header.php');?>
  
  <div id="content">
  
   <div id="dashboard-warrper">
   
   <div id="heading-text">
    <h1 class="create-account"> Dashboard </h1>
   </div> 
    
    <div class="three-col-row">
    
    <div class="three-col"><a href="./"><img src="../images/icons/dashboard.png" ><p class="dashboard-text">Dashboard</p></a></div>
    <div class="three-col"><a href="edit-profile.php"><img src="../images/icons/homework.png" > <p class="dashboard-text"> Edit Profile </p></a></div>
    <div class="three-col"><a href="calender.php"><img src="../images/icons/celender.png" > <p class="dashboard-text"> Calendar  </p></a></div>
    
    </div>
    
     <div class="three-col-row">
    
    <div class="three-col"><a href="change-password.php"><img src="../images/icons/schedule.png" > <p class="dashboard-text"> Change Password </p></a></div>
    <div class="three-col"><a href="profile.php"><img src="../images/icons/attendance.png" > <p class="dashboard-text"> View Profile </p></a></div>
    <div class="three-col"><a href="./"><img src="../images/icons/books.png" > <p class="dashboard-text"> Dashboard </p></a></div>
    <div class="three-col-row">
    <div class="three-col"><a href="my-expert.php"><img src="../images/icons/my-expert.png" > <p class="dashboard-text"> My Expert Refer </p></a></div>
    <div class="three-col"><a href="expert.php"><img src="../images/icons/find-expert.png" > <p class="dashboard-text"> Find Expert</p></a></div>
    </div>
    </div>

    
   </div> <!-- form warrper -->

  
  </div> <!-- content -->
  
  <!-- footer -->
    <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
