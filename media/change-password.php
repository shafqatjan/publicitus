<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_MEDIA);
$objSession->checkSession(CLIENT_ROLE_MEDIA,"../index.php") ;
$objDb = new Database();

$objDb->connect();
$objUser = new User();

$error    = '';

if(isset($_POST['btn_login']))
{
	//printArray($_POST);
	$objUser->password = isset($_POST['opassword'])?hlpSafeString($_POST['opassword'],'char'):'';
	$objUser->npassword = isset($_POST['npassword'])?hlpSafeString($_POST['npassword'],'char'):'';
	$objUser->cpassword = isset($_POST['cnpassword'])?hlpSafeString($_POST['cnpassword'],'char'):'';		
	$error .= $objUser->PasswordValidate();//exit;
	
	if(empty($error))
	{
		$objUser->id = $objSession->id;
		//echo $objUser->checkOldPassword();
 		$chkUserExist = $objDb->getArraySingle($objUser->checkOldPassword());
		//printArray($chkUserExist);exit;		
		if(count($chkUserExist)>0)
		{
			//echo $objUser->ChangePassword();exit;
			if($objDb->execute($objUser->ChangePassword()))
			{
				$objSession->setSessMsg("Password has been changed successfully.");
				$objSession->redirectTo("change-password.php");
			}			
		}
		else
			$error .= '&bull;&nbsp;Invalid old password.';
	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Publicitus</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/lib/jquery.js"></script>
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
    <form method="post">
      <div id="form-warrper">
        <?php include('../includes/err-succ-info.php');?>
        <div class="form-head">
          <h3> Change Password </h3>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Old Password </label>
          </div>
          <div class="col-two">
            <input type="password" id="opassword" name="opassword" value="">
          </div>
          <div class="error"></div>
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
            <input type="password" id="cnpassword" name="cnpassword" value="">
          </div>
          <div class="error"></div>
        </div>
        <div class="submit-btn" style="width:595px; padding-top:10px;">
          <input type="submit" value="Update" id="btn_login" name="btn_login">
          <input type="button" value="Cancel" onclick="window.location='<?php echo SITE_ROOT.'expert/';?>'">
        </div>
      </div>
      <!-- form warrper -->
    </form>
  </div>
  <!-- content --> 
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
</div>
<!-- Warpper -->

</body>
</html>
