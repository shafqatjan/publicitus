<?php

	include('../settings/settings.php');
	include('../helpers/helper.php');
	
	$objDb = new Database();
	$objSession = new Session();
	$objEducation = new Education();
	$objExperience = new Experience();


	$objDb->connect();
	$objUser = new User();
    global $objDb;
    global $objSession;
	global $objEducation;
	global $objExperience;
	
    $action=isset($_GET['action'])?$_GET['action']:die(1);
    if(!empty($action)){
		switch($action){
			case "add":
			        setValues($objDb,$objSession,$objEducation);
					if($objEducation->id == 0)
 					    addEducation($objDb,$objSession,$objEducation);
					else
 					    updateEducation($objDb,$objSession,$objEducation);
			break;

			case "edit":
	        		$objEducation->id = isset($_GET['id'])?$_GET['id']:'';			
					getRecord($objDb,$objSession,$objEducation);
			break;

			case "update":
			        setValues($objDb,$objSession,$objEducation);
					updateEducation($objDb,$objSession,$objEducation);
			break;

			case "delete":
	        		$objEducation->id = isset($_GET['id'])?$_GET['id']:'';
					deleteRecord($objDb,$objSession,$objEducation);
			break;

			case "addExperience":
			        setExpValues($objDb,$objSession,$objExperience);
					if($objExperience->id == 0)
 					    addExperience($objDb,$objSession,$objExperience);
					else
 					    updateExperience($objDb,$objSession,$objExperience);
			break;

			case "editExperience":
	        		$objExperience->id = isset($_GET['id'])?$_GET['id']:'';			
					getRecord($objDb,$objSession,$objExperience);
			break;

			case "deleteExperience":
	        		$objExperience->id = isset($_GET['id'])?$_GET['id']:'';			
					deleteRecord($objDb,$objSession,$objExperience);
			break;

		}
	}
	else die("Invalid access");

    function setValues($objDb,$objSession,$objEducation){

   		$objEducation->id = isset($_GET['id'])?$_GET['id']:'';
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


    function setExpValues($objDb,$objSession,$objExperience){

   		$objExperience->id = isset($_GET['id'])?$_GET['id']:'';
		$objExperience->job_title = isset($_GET['job_title'])?$_GET['job_title']:'';
		$objExperience->company = isset($_GET['company'])?$_GET['company']:'';
		$objExperience->start_month = isset($_GET['st_month'])?$_GET['st_month']:'';
		$objExperience->end_month = isset($_GET['e_month'])?$_GET['e_month']:'';
		$objExperience->start_year = isset($_GET['st_year'])?$_GET['st_year']:'';
		$objExperience->end_year = isset($_GET['e_year'])?$_GET['e_year']:'';
		$objExperience->edu_description = isset($_GET['job_description'])?$_GET['job_description']:'';
		$objExperience->user_id = $objSession->id;
	}


    function addEducation($objDb,$objSession,$objEducation){
		//echo $error = $objEducation->validate();
		//echo "<br> Query :: ".$objEducation->Add();
		if(empty($error)){
			if( $objDb->execute($objEducation->Add())){
				$last_id = $objDb->insert_id();
   					$objSession->setSessMsg("Record inderted successfully...");
					if($objEducation->start_month ==0)$objEducation->start_month="present";
					if($objEducation->start_year ==00)$objEducation->start_year="present";
					if($objEducation->end_month ==0)$objEducation->end_month="present";
					if($objEducation->end_year ==00)$objEducation->end_year="present";

	          echo "sucadd<tr id=row_".$last_id.">>
                <td>  <a id='edit-edu' onClick=edit(".$last_id.")> Edit</a>  <a  onClick=deleteRow(".$last_id.")> Delete</a> </td>
                <td>  ".$objEducation->start_year." </td>
                <td>  ".$objEducation->end_year ."  </td>
                <td>  ".$objEducation->school ."</td> 
                <td> ".$objEducation->degree.' '.$objEducation->subject."</td>
                                                               
            </tr>";
			}
			else{
					$objSession->setSessMsg("Record not inserted inderted...");	
					echo "Record not inderted successfully...";			
			}
		}

	}
	


    function addExperience($objDb,$objSession,$objExperience){
		//echo $error = $objExperience->validate();
		//echo "<br> Query :: ".$objExperience->Add();
		if(empty($error)){
			if( $objDb->execute($objExperience->Add())){
				$last_id = $objDb->insert_id();
   					$objSession->setSessMsg("Record inderted successfully...");
					if($objExperience->start_month ==0)$objExperience->start_month="present";
					if($objExperience->start_year ==00)$objExperience->start_year="present";
					if($objExperience->end_month ==0)$objExperience->end_month="present";
					if($objExperience->end_year ==00)$objExperience->end_year="present";

	          echo "sucadd<tr id=row_".$last_id.">>
                <td>  <a id='edit-edu' onClick=edit(".$last_id.")> Edit</a>  <a  onClick=deleteRow(".$last_id.")> Delete</a> </td>
                <td>  ".$objExperience->start_year." </td>
                <td>  ".$objExperience->end_year ."  </td>
                <td>  ".$objExperience->company ."</td> 
                <td> ".$objExperience->job_title."</td>
                                                               
            </tr>";
			}
			else{
					$objSession->setSessMsg("Record not inserted inderted...");	
					echo "Record not inderted successfully...";			
			}
		}

	}
	

	function getRecord($objDb,$objSession,$obj){

           	$sql = $obj->PopulateGrid("*"," AND id= ".$obj->id);  
			$record = $objDb->getArraySingle($sql);
            echo json_encode($record);
 		
	}

   function updateEducation($objDb,$objSession,$objEducation){
		$error = $objEducation->validate();
		//echo "<br> Query :: ".$objEducation->Update();
		if(empty($error)){
			if( $objDb->execute($objEducation->Update())){
   					$objSession->setSessMsg("Record updated successfully...");
					//echo "Record updated successfully...";
					if($objEducation->start_month ==0)$objEducation->start_month="present";
					if($objEducation->start_year ==00)$objEducation->start_year="present";
					if($objEducation->end_month ==0)$objEducation->end_month="present";
					if($objEducation->end_year ==00)$objEducation->end_year="present";

 	                echo "sucupd<td>  <a id='edit-edu' onClick=edit(".$objEducation->id.")> Edit</a>  <a  onClick=deleteRow(".$objEducation->id.")> Delete</a> </td>
						<td>  ".$objEducation->start_year." </td>
						<td>  ". $objEducation->end_year ."  </td>
						<td>  ".$objEducation->school ."</td> 
						<td> ".$objEducation->degree.' '.$objEducation->subject."</td>";
					
			}
			else{
					$objSession->setSessMsg("Record not updated ...");	
					echo "Record not updated successfully...";			
			}
		}

	}


   function updateExperience($objDb,$objSession,$objExperience){
		$error = $objExperience->validate();
		//echo "<br> Query :: ".$objExperience->Update();
		if(empty($error)){
			if( $objDb->execute($objExperience->Update())){
   					$objSession->setSessMsg("Record updated successfully...");
					//echo "Record updated successfully...";
					if($objExperience->start_month ==0)$objExperience->start_month="present";
					if($objExperience->start_year ==00)$objExperience->start_year="present";
					if($objExperience->end_month ==0)$objExperience->end_month="present";
					if($objExperience->end_year ==00)$objExperience->end_year="present";

 	                echo "sucupd<td>  <a id='edit-edu' onClick=edit(".$objExperience->id.")> Edit</a>  <a  onClick=deleteRow(".$objExperience->id.")> Delete</a> </td>
						<td>  ".$objExperience->start_year." </td>
						<td>  ". $objExperience->end_year ."  </td>
						<td>  ".$objExperience->company ."</td> 
						<td> ".$objExperience->job_title."</td>";
					
			}
			else{
					$objSession->setSessMsg("Record not updated ...");	
					echo "Record not updated successfully...";			
			}
		}

	}


   function deleteRecord($objDb,$objSession,$obj){
//		$error = $objEducation->validate();
		if(empty($error)){
			if( $objDb->execute($obj->Delete())){
   					$objSession->setSessMsg("Record removed successfully...");
			}
			else{
					$objSession->setSessMsg("Record not removed...");	
			}
		}

	}
	
?>