<?php

	include('../settings/settings.php');
	include('../helpers/helper.php');
	
	$objDb = new Database();
	$objSession = new Session();
	$objEducation = new Education();


	$objDb->connect();
	$objUser = new User();
    global $objDb;
    global $objSession;
	global $objEducation;
	
    $action=isset($_GET['action'])?$_GET['action']:die(1);
    if(!empty($action)){
		switch($action){
			case "add":
			        setValues($objDb,$objSession,$objEducation);
					addEducation($objDb,$objSession,$objEducation);
			break;

			case "edit":
			        setValues($objDb,$objSession,$objEducation);
					updateEducation($objDb,$objSession,$objEducation);
			break;

			case "update":
			        setValues($objDb,$objSession,$objEducation);
					updateEducation($objDb,$objSession,$objEducation);
			break;

			case "delete":
			        setValues($objDb,$objSession,$objEducation);
					deleteEducation($objDb,$objSession,$objEducation);
			break;


		}
	}
	else die("Invalid access");

    function setValues($objDb,$objSession,$objEducation){

		$objEducation->degree = isset($_GET['degree'])?$_GET['degree']:'';
		$objEducation->subject = isset($_GET['subject'])?$_GET['subject']:'';
		$objEducation->school = isset($_GET['school'])?$_GET['school']:'';
		$objEducation->start_month = isset($_GET['start_month'])?$_GET['start_month']:'';
		$objEducation->end_month = isset($_GET['end_month'])?$_GET['end_month']:'';
		$objEducation->start_year = isset($_GET['start_year'])?$_GET['start_year']:'';
		$objEducation->end_year = isset($_GET['end_year'])?$_GET['end_year']:'';
		$objEducation->edu_description = isset($_GET['edu_description'])?$_GET['edu_description']:'';
		$objEducation->user_id = $objSession->id;
	}

    function addEducation($objDb,$objSession,$objEducation){
		echo $error = $objEducation->validate();
		echo "<br> Query :: ".$objEducation->Add();
		if(empty($error)){
			if( $objDb->execute($objEducation->Add())){
				$last_id = $objDb->insert_id();
   					$objSession->setSessMsg("Record inderted successfully...");
					echo "Record inderted successfully...";
			}
			else{
					$objSession->setSessMsg("Record not inserted inderted...");	
					echo "Record not inderted successfully...";			
			}
		}

	}
	

   function updateEducation($objDb,$objSession,$objEducation){
		$error = $objEducation->validate();
		echo "<br> Query :: ".$objEducation->Update();
		if(empty($error)){
			if( $objDb->execute($objEducation->Update())){
   					$objSession->setSessMsg("Record updated successfully...");
					echo "Record updated successfully...";
			}
			else{
					$objSession->setSessMsg("Record not updated inderted...");	
					echo "Record not updated successfully...";			
			}
		}

	}


   function deleteEducation($objDb,$objSession,$objEducation){
		$error = $objEducation->validate();
		if(empty($error)){
			if( $objDb->execute($objEducation->Delete())){
   					$objSession->setSessMsg("Record removed successfully...");
			}
			else{
					$objSession->setSessMsg("Record not removed...");	
			}
		}

	}
	
?>