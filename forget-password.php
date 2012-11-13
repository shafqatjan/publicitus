<?php
include('settings/settings.php');
include('helpers/helper.php');

$objSession = new Session();
$objDb = new Database();

$objDb->connect();
$objUser = new User();

$error    = '';

if(isset($_POST['forgotBtn']))
{
	$objUser->email = isset($_POST['email'])?hlpSafeString($_POST['email'], 'char'):''; 
	
	$error .= $objUser->validateForgot();
	
	if(empty($error))
	{
			if($objDb->query($objUser->PopulateGrid('id, email', " AND email = '".hlpMysqlRealScape($objUser->email)."'")) && $objDb->get_num_rows()>0)
				try
				{
					$tmpRow = $objDb->fetch_row_assoc();
					//printArray($tmpRow);
					$userID = $tmpRow['id'];
					$loginEmail = $tmpRow['email'];
					
					$vCode = md5(date('shymi').$loginEmail);
					
					$objUser->id = $userID;
					$objUser->verification_code = $vCode;
					//echo $objUser->UpdateVarificationCode();exit;
					if($objDb->execute($objUser->UpdateVarificationCode()))
						$doEmail = 1;
					else
						$error .= '&nbsp;&bull;&nbsp;Invalid error accured.<br>';	
				}
				catch (Exception $e)
				{
					$error .= '&nbsp;&bull;&nbsp;Invalid error accured.<br>';	
				}
			else
				$error .= '&nbsp;&bull;&nbsp;Email not found in our record.<br>';	
			
			// Sending Email
			if($doEmail)
			{
				$objEmail = new cMail();
				$objEmail->To = $loginEmail;
				$objEmail->RepName = $loginEmail;
				$objEmail->Subject = 'Password Reset Request';
				$objEmail->From = EMAIL_NO_REPLY;
				
				$objEmail->BodyMsg  = '<br />';
				$objEmail->Content  = '<strong>Email</strong>: '.$loginEmail;
				$objEmail->Content .= '<br /><a href="'.SITE_ROOT.'reset-password.php?token='.$vCode.'">'.SITE_ROOT.'reset-password.php?token='.$vCode.'</a>';
				//printArray($objEmail);
				
				if($objEmail->SendEmail())
				{
					$objSession->setSessMsg("Forgot password email has been sent successfully. please check your email.");
					$objSession->redirectTo("login.php");
				}
			}
			
	}



}

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title>Publicitus</title>
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
    <form method="post">
      <div id="form-warrper">
        <?php include('includes/err-succ-info.php');?>
        <div class="form-head">
          <h3> Forget Password </h3>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Email </label>
          </div>
          <div class="col-two">
            <input type="text" id="email" name="email" value="<?php echo $objUser->email?>">
          </div>
          <div class="error"></div>
        </div>
        <div style="margin:0">
          <div class="submit-btn" style="width:130px; padding-top:10px; float:left">
            <input type="submit" value="Send" id="forgotBtn" name="forgotBtn">
          </div>
          <div class="submit-btn" style="width:130px; padding-top:10px; float:right">
            <input type="button" value="Cancel" onClick="window.location='login.php'">
          </div>
        </div>
      </div>
      <!-- form warrper -->
    </form>
  </div>
  <!-- content --> 
  
  <!-- footer -->
  <?php include('includes/footer.php');?>
</div>
<!-- Warpper -->

</body>
</html>
