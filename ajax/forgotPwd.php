<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);

$type = $_GET['type'];
$userEmail = isset($_GET['email']) && !empty($_GET['email'])?hlpTrimValue($_GET['email']):die('<span>'.$errorFoundMsgMenu.'</span>&nbsp;&bull;&nbsp;'.$emialIdBlankMsgMenu);
 
 

if(hlpValidEmail($userEmail))
{
	if($type==1)
		$objUser = new SchoolAdmin();
	if($type==2)
		$objUser = new SchoolSuperAdmin();
	$objDb = new Database();
	$objDb->connect();
	
	$doEmail = 0;
	
	if($objDb->query($objUser->PopulateGrid('id, user_name', " AND email = '".hlpMysqlRealScape($userEmail)."'")) && $objDb->get_num_rows()>0)
		try
		{
			$tmpRow = $objDb->fetch_row_assoc();
			$userID = $tmpRow['id'];
			$loginName = $tmpRow['user_name'];
			
			$vCode = md5(date('shymi').$userEmail);
			
			$objUser->id = $userID;
			$objUser->verificationCode = $vCode;
			if($objDb->execute($objUser->UpdateVarificationCode()))
				$doEmail = 1;
			else
				die('<span>'.$errorFoundMsgMenu.'</span>&nbsp;&bull;&nbsp;'.$invaliderrorMsgMEnu);	
		}
		catch (Exception $e)
		{
			die('<span>'.$errorFoundMsgMenu.'</span>&nbsp;&bull;&nbsp;'.$invaliderrorMsgMEnu);
		}
	else
		die('<span>'.$errorFoundMsgMenu.'</span>&nbsp;&bull;&nbsp;'.$invalidEmailIdMsgMenu);
	
	// Sending Email
	if($doEmail)
	{
		$objEmail = new cMail();
		$objEmail->To = $userEmail;
		$objEmail->RepName = $loginName;
		$objEmail->Subject = 'Password Reset Request';
		$objEmail->From = EMAIL_NO_REPLY;
		
		$objEmail->BodyMsg  = '<br />'.$emailText1MsgMenu.SITE_ROOTADMIN;
		$objEmail->Content  = '<strong>'.$emailText2MsgMenu.'</strong> '.$loginName.'<br /><br />'.$emailText3MsgMenu;
		$objEmail->Content .= '<br /><a href="'.SITE_ROOTADMIN.'reset-password.php?token='.$vCode.'">'.SITE_ROOTADMIN.'reset-password.php?token='.$vCode.'</a>';
		$objEmail->Content .= '<br /><br />('.$emailText4MsgMenu.')<br /><br />';
		
		$objEmail->SendEmail();
		die('');
	}
}
die('<span>Error found.</span>&nbsp;&bull;&nbsp;Invalid Email ID.');
?>