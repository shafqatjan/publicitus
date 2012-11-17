<?php
include('settings/settings.php');
include('helpers/helper.php');

$objSession = new Session();
$objDb = new Database();

$objDb->connect();
$objUser = new User();

$error    = '';
$remember = 'off';
//printArray($_COOKIE);
if(isset($_COOKIE['user']))
	$objUser->email = $_COOKIE['user'];

if(isset($_POST['btn_login']))
{
	//printArray($_POST);
	$objUser->email = isset($_POST['email'])?hlpSafeString($_POST['email'], 'char'):''; 
	$objUser->password = isset($_POST['password'])?hlpSafeString($_POST['password'],'char'):'';
	$remember = isset($_POST['remember'])?hlpSafeString($_POST['remember'],'char'):'off';
	$error .= $objUser->validateLogin();//exit;
	
	if(empty($error))
	{
 		$chkUserExist = $objDb->getArraySingle($objUser->emailExists());
		//printArray($chkUserExist);exit;		
		if(count($chkUserExist)>0)
		{
 		    $chkLogin = $objDb->getArraySingle($objUser->checkLogin());
			//printArray($chkLogin);exit;
			if(count($chkLogin)>0)
			{  
				$objSession->id = $chkLogin['id'];
				$objSession->email = $chkLogin['email'];
				$objSession->user_type = $chkLogin['user_type'];	
				$objSession->user_name = $chkLogin['first_name'];			
				//1=expert,2=manager,3=advertiser,4=media
				$redirecto = '';
				if($chkLogin['user_type']=='1')
				{
					$objSession->role = CLIENT_ROLE_EXPERT;
					$redirecto = 'expert';
				}
				if($chkLogin['user_type']=='2')
				{
					$objSession->role = CLIENT_ROLE_MANAGER;
					$redirecto = 'manager';
				}				
				if($chkLogin['user_type']=='3')
				{
					$objSession->role = CLIENT_ROLE_ADVERTISER;
					$redirecto = 'advertiser';
				}
				if($chkLogin['user_type']=='4')
				{
					$objSession->role = CLIENT_ROLE_MEDIA;
					$redirecto = 'media';
				}								
				$_SESSION['last_time'] = time();
				//printArray($objSession);exit;
				if($remember=='on')
					$objSession->setCookies('user',$objUser->email);
					
				$objSession->setSession('', $redirecto);
			}
			else
				$error .= '&bull;&nbsp;Username or password is invalid.';
		}
		else
			$error .= '&bull;&nbsp;Username or password is invalid.';
	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta charset="utf-8">
<title>Publicitus</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/lib/jquery.js"></script>
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
    	<h3> Sign In </h3>
    </div>
   
    <div class="two-col">
     <div class="col-one"> <label> Email </label> </div>     
     <div class="col-two"> <input type="text" id="email" name="email" value="<?php echo $objUser->email;?>"> </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col">
     <div class="col-one"> <label> Password </label> </div>     
     <div class="col-two"> <input type="password" id="password" name="password"> </div>
     <div class="error"></div>
    </div>
  
     <div class="rember-me">
       <input type="checkbox" id="remember" name="remember" <?php if($remember=='on'){echo 'checked="checked"';}?>> Remember Me
    </div>
 
    <div class="submit-btn" style="width:595px; padding-top:10px;">
     <input type="submit" value="Sign In" id="btn_login" name="btn_login">
     <span class="forget-pass"> 
      <a href="forget-password.php"> Forgot your password? </a> 
     </span>
    </div>
    
   </div> <!-- form warrper -->
	</form>
  
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
