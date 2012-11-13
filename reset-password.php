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

$error = 'Password Reset Request cannot proceed due to the following reasons:<br />
		<ul style="color:red;padding: 20px;">
			<li>Invalid Token Number.</li>
			<li>Password Reset Link has been expired.<br /></li>
		</ul>
		Click <a href="'.SITE_ROOT.'">here</a> to go to login page.';
$userID = '';
$email='';
if($getToken)
{
	$sql = $objUser->PopulateGrid("id,email", " and verification_code = '".htmlspecialchars(mysql_real_escape_string($getToken))."'");
	if($objDb->query($sql) && $objDb->get_num_rows()>0)
	{
		$row = $objDb->fetch_row_assoc();
		$userID = $row['id'];
		$email = $row['email'];
		
		$error = "";
/*		$objUser->status = 3;
		$objUser->id = $userID;
		$objUser->verification_code = 'null';
		
        $objDb->execute($objUser->UpdateStatus());
        $objDb->execute($objUser->UpdateField(verification_code,$objUser->verification_code));

		$objSession->setSessMsg("Your account is verified successfully, now you can login.");
		$objSession->redirectTo("login.php");
*/
		
		// test token exist in db
		// change status from 3 to 1
		// empty vcode
		// redirect to login with some proper msg via sessiob redirect method
	}
}

if (isset($_POST['btn_update']))
{
	 $new_password	= isset($_POST['npassword'])?$_POST['npassword']:'';
	 $con_password	= isset($_POST['cpassword'])?$_POST['cpassword']:'';
	
		if(!$new_password)
			$error .="&bull;&nbsp;New Password cannot be left blank.<br/>";

		if(!$con_password)
			$error .="&bull;&nbsp;Confirm Password cannot be left blank.<br/>";
		else if($new_password != $con_password)
			$error .="&bull;&nbsp;Password mismatched.<br>";

		if(empty($error))
		{
			$objUser->id = $userID;
			$objUser->email = $email;
			//$cur_password=md5($cur_password);

			$objUser->verification_code = '';
			//echo $objUser->UpdateVarificationCode();exit;
			if($objDb->execute($objUser->UpdateVarificationCode()))
				$doEmail = 1;
				
				if($doEmail==1)
				{
					$objUser->password = $new_password;
					$sql_chg = $objUser->UpdatePwdViaEmail();
					if($objDb->execute($sql_chg))
					{
						$objEmail = new cMail();
						$objEmail->To = $email;
						$objEmail->RepName = $email;
						$objEmail->Subject = 'Password has been reseted.';
						$objEmail->From = EMAIL_NO_REPLY;
						
						$objEmail->BodyMsg  = '<br />';
						$objEmail->Content  = '<strong>Email</strong>: '.$email;
						$objEmail->Content  = '<br>Your password has been changed successfully.';						

						//printArray($objEmail);
						
						if($objEmail->SendEmail())
						{
							$objSession->setSessMsg("Password has been reseted successfully.");
							$objSession->redirectTo("login.php");
						}						
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
    <form method="post">
      <div class="form-head">
        <h3> Reset Password </h3>
      </div>
      <div class="two-col">
        <div class="col-one">
          <label> New Password </label>
        </div>
        <div class="col-two">
          <input type="password" id="npassword" name="npassword" value="">
        </div>
        <div class="error"></div>
      </div>
      <div class="two-col">
        <div class="col-one">
          <label> Confirm Password </label>
        </div>
        <div class="col-two">
          <input type="password" id="cpassword" name="cpassword" value="">
        </div>
        <div class="error"></div>
      </div>
      <div class="submit-btn" style="width:130px; padding-top:10px; float:left">
        <input type="submit" value="Reset" id="btn_update" name="btn_update">
      </div>
      </div>
    </form>
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