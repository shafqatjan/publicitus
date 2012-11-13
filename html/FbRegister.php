<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session();
$objDb = new Database();

$objDb->connect();
$objUser = new User();
//echo '<pre>';print_r($_GET);

$email = $_GET['email'];

$total = $objDb->GetCountSql($objUser->table," AND status=1 And email='".$email."'");

$_SESSION['isFbRegister'] = 1;

if($total>=1)
{
	echo "<div class='myDiv' style='width:400px;height:auto;font-family:Arial, Helvetica, sans-serif;font-size:16px;font-weight: bold;text-decoration:none;	padding:5px;'>Redirecting please wait........</div>";
	sleep(1);
	$sqlUserData = $objUser->PopulateGrid("*"," AND email ='".$email."'");
	$userArray = $objDb->getArraySingle($sqlUserData);

				$objSession->id = $userArray['id'];
				$objSession->email = $userArray['email'];
				$objSession->user_type = $userArray['user_type'];				
				//1=expert,2=manager,3=advertiser,4=media
				$redirecto = '';
				if($userArray['user_type']=='1')
				{
					$objSession->role = CLIENT_ROLE_EXPERT;
					$redirecto = 'expert';
				}
				if($userArray['user_type']=='2')
				{
					$objSession->role = CLIENT_ROLE_MANAGER;
					$redirecto = 'manager';
				}				
				if($userArray['user_type']=='3')
				{
					$objSession->role = CLIENT_ROLE_ADVERTISER;
					$redirecto = 'advertiser';
				}
				if($userArray['user_type']=='4')
				{
					$objSession->role = CLIENT_ROLE_MEDIA;
					$redirecto = 'media';
				}								
				$_SESSION['last_time'] = time();

	$objSession->setSessionFB();
	
	$_SESSION['isFbRegister'] = '';
	unset($_SESSION['isFbRegister']);
	?>
    <script>
		parent.reloadMe();
	</script>
	<?php
	exit;	
}
	
$goto = isset($_GET['goto'])?$_GET['goto']:"index.php";
?>
<script>

function callingLoginFB()
{
	var userType=jQuery("#r").val();				
	var email=jQuery("#register_email").val();			
	var password=jQuery("#register_password").val();	
	var cpassword=jQuery("#cregister_cpassword").val();		

	var err=0;	
	var errTxt = ""; 
	jQuery('#errSpn').html("");

	if(!r)
	{
		errTxt +='&nbsp;&bull;&nbsp;Please select user type.<br>';
		err=1;
	}
	if(!password)
	{
		errTxt +='&nbsp;&bull;&nbsp;Password cannot be left blank.<br>';
		err=1;
	}
	if(!cpassword)
	{
		errTxt +='&nbsp;&bull;&nbsp;Confirm password cannot be let blank.<br>';
		err=1;
	}	
	else if(password!=cpassword)
	{
		errTxt +='&nbsp;&bull;&nbsp;Password mismatch.<br>';
		err=1;
	}
	if(err)
	{
		jQuery('#errSpn').html(errTxt);
		return false;	
	}

	param =  "act=callingFbRegister&username=&password="+password+"&email="+email+"userType="+r;
	//alert(param);
	var errFound = 0;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   async	: false,
		   url 		: 'ajax/action.php',
		   success 	: function(msg){
			    alert(msg);
			  	if(msg=='ERROR')
				{
					jQuery('#errSpn').html('&nbsp;&bull;&nbsp;كلمة السر قصيرة جدا او غير مسموح بها');
					errFound = 1;		
				}
			  	else if(msg==1)
				{
					jQuery('#errSpn').html('&nbsp;&bull;&nbsp;اسم المستخدم موجود بالفعل');
					errFound = 1;		
				}					
				else
					errFound = 0;
		   }
		});

		if(errFound)
			return false;
		else
			return true;
		//jQuery(".example7").colorbox({width:"600px", height:"320px", iframe:true, overlayClose:false, opacity:0.40 });	
}

</script>
<style>
#myDiv
{
	width:400px;
	height:auto;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:normal;
	text-decoration:none;
	padding:5px;
}
.myDiv
{
	width:400px;
	height:auto;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	font-weight: bold;
	text-decoration:none;
	padding:5px;
}
#myDiv div
{
	float:left;
	width:130px;
	height:auto;
	margin:8px 8px 2px 1px;
}
.myInput
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:normal;
	text-decoration:none;
	border:1px solid #cccccc;
	width:350px;
	padding:3px;
}
.myBtn
{
    border:1px solid #cccccc;;
    color:#000000;
    cursor: pointer;
    font: bold 12px Arial,Helvetica,sans-serif;
    margin:8px auto;
    text-align: center;
	padding:5px;   
}
</style>
<div class="myDiv">FB login</div>
<form method="post" action="index.php">
<input type="hidden" id="goto" name="goto" value="<?php echo $goto;?>">
<div id="myDiv">
    <div>User Type:*</div> 
    <input type="radio" value="1" id="r" name="r"> Expert
    <input type="radio" value="2" id="r" name="r"> Manager
    <input type="radio" value="3" id="r" name="r"> Advertiser
    <input type="radio" value="4" id="r" name="r"> Media
	<div>Password:*</div> 
    <input name="register_password" id="register_password" type="password" class="myInput" value=""/>
	<div>Confirm Password:*</div> 
    <input name="cregister_cpassword" id="cregister_cpassword" type="password" class="myInput"  value=""/>
    <div>Email:*</div> 
    <input name="register_email" id="register_email" type="text" class="myInput" value="<?php echo $email?>"  readonly="readonly" onblur="callingCheckEmail();"/>
	<input type="hidden" id="register_dob" name="register_dob" value="<?php echo $dob;?>">
	<input type="submit" id="login_btn" name="login_btn" value="Submit" class="myBtn"  onclick="return callingLoginFB();" >
    <span id="errSpn" class="required-text"></span>
</div>
</form>