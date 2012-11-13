<?php

	include('../settings/settings.php');
	include('../helpers/helper.php');
	
	$objSession = new Session();
	$objDb = new Database();
	
	$objDb->connect();
	$objUser = new User();
	
    $action=isset($_GET['act'])?$_GET['act']:die(1);
	

	if($action=='callingCheckUsername')
	{
		$username = isset($_GET['user'])?$_GET['user']:'';
		
		echo $objDb->GetCountSql($objUser->table," and user_name='".$username."'");		
	}
	

	if($action=='callingFbRegister')
	{
		$register_email = isset($_GET['email'])?$_GET['email']:'';
		$register_fname = isset($_GET['fname'])?$_GET['fname']:'';		
		$register_userType = isset($_GET['userType'])?$_GET['userType']:'';		
		$register_pass = isset($_GET['password'])?$_GET['password']:'';				
		//echo $db->GetCountSql($objUser->table, " AND user_name='".$register_username."'");
		if($objDb->GetCountSql($objUser->table, " AND email='".$register_email."'")>0 )
		{
			echo 2;exit;
		}	

		$register_password = $register_email;
		$register_email = $_GET['email'];		
		$objUser->email = $register_email;
		$objUser->password =md5($register_pass);		
		$objUser->user_type =$register_userType;			
		$objUser->first_name =$register_fname;						

	
			$qryAdd=$objUser->AddByUsertype();
	
			if($objDb->execute($qryAdd))
			{
				sleep(0.5);		
				//echo '<pre>';		print_r($objUser);
				$objSession->id = mysql_insert_id();
				$objSession->email = $objUser->email;
				$objSession->user_type = $objUser->user_type;				
				$objSession->user_name = $objUser->first_name;
				//1=expert,2=manager,3=advertiser,4=media
				if($userArray['user_type']=='1')
					$objSession->role = CLIENT_ROLE_EXPERT;
				if($userArray['user_type']=='2')
					$objSession->role = CLIENT_ROLE_MANAGER;
				if($userArray['user_type']=='3')
					$objSession->role = CLIENT_ROLE_ADVERTISER;
				if($userArray['user_type']=='4')
					$objSession->role = CLIENT_ROLE_MEDIA;

				$_SESSION['last_time'] = time();
				$objSession->setSessionFB();
			?>
				<script>
					parent.reloadMe();
				</script>
			<?php
	
				exit;				
	
			}
	

	
	}
	
?>