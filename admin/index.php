<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);

$objDb = new Database();

$objDb->connect();
$objAdmin = new Admin();

$error    = '';

if(isset($_POST['btn_login']))
{
	$objAdmin->user_name = isset($_POST['user_name'])?hlpSafeString($_POST['user_name'], 'char'):''; 
	$objAdmin->password = isset($_POST['password'])?$_POST['password']:'';
	
	$error .= $objAdmin->validate();
	
	if(!$error)
	{
 		$chkUserExist = $objDb->getArraySingle($objAdmin->userExists());
		
		if(count($chkUserExist)>=0)
		{
 		    $chkLogin = $objDb->getArraySingle($objAdmin->checkLogin());
			if(count($chkLogin)>0)
			{  
				$objSession->id = $chkLogin['id'];
				$objSession->username = $chkLogin['user_name'];
				$objSession->role = ADMIN_ROLE;
				$_SESSION['last_time'] = time();
//				printArray($objSession);exit;
				$objSession->setSession();
			
			}
			else
				$error .= '&bull;&nbsp;Username or password is invalid.';
		}
		else
			$error .= '&bull;&nbsp;Username or password is invalid.';
		
		
	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PAGE_TITLE;?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<link rel="stylesheet" type="text/css" href="../css/login.css"/>

<script type="text/javascript" src="../js/lib/jquery.js"></script>

<script>
jQuery(function()
{
	jQuery("#user_name").focus();
})

function sendPwd()
{
	jQuery(".error").hide().html("");
	var email = jQuery("#forgotEmail").val();
	
	 if(email==null)
	 {
		 jQuery(".error").show().html("Email cannot be left blank.");
		 return false;
	 }
	jQuery.ajax({
		type	:	"GET",
		url		:	"../ajax/forgotPwd.php",
		data	: 	"email="+email+"&type=1",
		async	: 	false,
		success :	function(rtnMsg)
		{
			
			if(rtnMsg == '1')
			{
				jQuery("#forgotError").css({'background-color':'#aaedb2'});
				jQuery("#forgotError").css({'border':'1px solid green'});
				jQuery("#forgotError").css({'padding-top':'7px'});
				
				jQuery("#forgotError").html('An Email has been sent to your email address. Please login to your email and follow the instructions.').show().fadeOut(7000);
				jQuery("#forgotEmail").val("");
				
				setTimeout( function()
				{
					jQuery('#forgotDiv').slideToggle();
					jQuery("#forgotError").css({'background-color':'#f5f5f5'});
					jQuery("#forgotError").css({'border':'1px solid red'});
					jQuery("#forgotError").css({'padding-top':'0px'});
					
				},7000);
				return false;
			}
			jQuery("#forgotError").html(rtnMsg).show();
		}
	});
}
</script>
</head>
<body style="">
<div id="maincont">
	
  <div id="pts">
    <?php echo ADMIN_PAGE_HEADING;?>
  </div>
  	<div class="loginbox">
    <form method="post">
		<?php if($error)
        {
        ?>
            <div id="error" class="error"><span>Errors found.</span><?php echo $error;?></div>
        <?php
        }
        ?>
        <?php echo $objSession->getSessMsg(); ?>
		                <span>User Name*:</span>
        <input type="text" name="user_name" id="user_name" class="loginfield" value="" />
        <span>Password*:</span>
        <input type="password" name="password" id="password" class="loginfield" maxlength="20" value="" />
        <span><input type="checkbox" name="remchk" id="remchk"  /> Remember me on this computer.</span>

        <span><input type="submit" name="btn_login" id="submit" value="Login" class="loginbtn" /></span>
        <hr class="loginhr" />
        <strong>Help:</strong> <a href="javascript:void(0);" onclick="jQuery('#forgotDiv').slideToggle();">I forgot my User Name or password?</a>        
     </form>
         <div style="display:none; padding-bottom:8px;" id="forgotDiv">
         <div id="forgotError" class="error" style="display:none;"></div>
         <span>Enter your Email address:*</span>
          
         <input type="text" name="forgotEmail" id="forgotEmail" style="width:250px;" class="loginfield" />
         <button class="loginbtn" onclick="sendPwd();">Send</button>
         </div>
     
     <span>&nbsp;</span>
     <?php echo ADMIN_PAGE_FOOTER;?>
     </div>
</div>
</body>
</html>