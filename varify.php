<?php
include('settings/settings.php');
include('helpers/helper.php');

$objSession = new Session();
$objDb = new Database();
$objDb->connect();
$objUser = new User();
//$objFun = new Functions();	

$new_password = "";
$con_password = "";

$first_name	= "";
$userID 	= "";

$error 		= "";

$getToken = isset($_GET['token'])?$_GET['token']:"";
$link_URL = "login";

$defaultMsg = 'Password Reset Request cannot proceed due to the following reasons:<br />
		<ul style="color:red;">
			<li>Invalid Token Number.</li>
			<li>Password Reset Link has been expired.<br /></li>
		</ul>
		Click <a href="'.SITE_ROOTADMIN.'">here</a> to go to login page.';

if($getToken)
{
	 $sql = $objUser->PopulateGrid("id, first_name", " and verification_code = '".htmlspecialchars(mysql_real_escape_string($getToken))."'");
	if($objDb->query($sql) && $objDb->get_num_rows()>0)
	{
		$row = $objDb->fetch_row_assoc();
		$userID = $row['id'];
		$first_name = $row['first_name'];
		
		$defaultMsg = "";
		$objUser->status = 1;
		$objUser->id = $userID;
		$objUser->verification_code = 'null';
		
        $objDb->execute($objUser->UpdateStatus());
        $objDb->execute($objUser->UpdateField('verification_code',$objUser->verification_code));

		$objSession->setSessMsg("Your account is verified successfully, now you can login.");
		$objSession->redirectTo("login.php");

		
		// test token exist in db
		// change status from 3 to 1
		// empty vcode
		// redirect to login with some proper msg via sessiob redirect method
	}
}

if (isset($_POST['btn_update']))
{
	 $new_password	= $_POST['newpassword'];
	 $con_password	= $_POST['confirmpassword'];
	
		if(!$new_password)
		{
			$error .="&bull;&nbsp;New Password cannot be left blank.<br/>";
		}
		if(!$con_password)
		{
			$error .="&bull;&nbsp;Confirm Password cannot be left blank.<br/>";
		}
		else if($new_password != $con_password)
		{
			$error .="&bull;&nbsp;Password mismatched.<br>";
		} 

		if(empty($error))
		{
			$objUser->id = $userID;
			$objUser->password = $cur_password;
			$cur_password=md5($cur_password);

			$objUser->verificationCode = '';
			if($objDb->execute($objUser->UpdateVCode()))
				$doEmail = 1;
				
				if($doEmail==1)
				{
					$objUser->password = md5($new_password);
					$sql_chg = $objUser->ResetPassword();
					if($objDb->execute($sql_chg))
					{
						$objSession->setSessMsg("Password has been resetted successfully. Please Login.");
						$objSession->redirectTo($link_URL);
					}
				}
				else
				{
					$error  .="&bull;&nbsp;Password has not been changed.<br/>";
				}
		}
	}



?>
<html>
<head>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/modernizr.js"></script>
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
  <?php include('includes/header.php');?>
  <div id="content">
      <div id="form-warrper">
      <?php include("includes/err-succ-info.php");  ?>
	 
      </div>
      <!-- form warrper -->
  </div>
  <!-- content --> 
  
  <!-- footer -->
 <?php include('includes/footer.php');?> 
</div>
</body>
</html>
<?php
$objDb->close();
?>