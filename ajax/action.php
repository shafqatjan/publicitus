<?php

	include('../settings/settings.php');
	include('../helpers/helper.php');
	
	$objSession = new Session();
	$objDb = new Database();
	
	$objDb->connect();
	$objUser = new User();
	
    $action=isset($_GET['act'])?$_GET['act']:die(1);
	
    if(!empty($action)){
		
		switch($action){
			case "addEducation":
					addEducation();
			break;
		}
	}
	else die("Invalid access");

    function addEducation(){

		$objEducation = new Education();
		echo  "Session Id :: "+$objSession->id;

		$objEducation->degree = isset($_GET['degree'])?$_GET['degree']:'';
		$objEducation->subject = isset($_GET['subject'])?$_GET['subject']:'';
		$objEducation->start_date = isset($_GET['start_date'])?$_GET['start_date']:'';
		$objEducation->end_date = isset($_GET['end_date'])?$_GET['end_date']:'';
		$objEducation->is_present = isset($_GET['is_present'])?$_GET['is_present']:'';
		$objEducation->user_id = $objSession->id;
		
		$error = $objEducation->validate();
		if(empty($error)){
			$objEducation->Add();
		}
		
		
		
		

	}
	


?>