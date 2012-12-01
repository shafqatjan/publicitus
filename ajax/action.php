<?php

	include('../settings/settings.php');
	include('../helpers/helper.php');
	
	$objDb = new Database();
	$objSession = new Session();
	$objEducation = new Education();
	$objExperience = new Experience();
	$objShow = new Shows();

	$objDb->connect();
	$objUser = new User();

    global $objDb;
    global $objSession;
	global $objEducation;
	global $objExperience;
	global $objShow;
	
    $action=isset($_GET['action'])?$_GET['action']:die(1);



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
					if($objExperience->id == 0){
						//echo "Going to call addExperience ";
 					    addExperience($objDb,$objSession,$objExperience);
					}
					else{
						//echo "Going to call updateExperience ";
 					    updateExperience($objDb,$objSession,$objExperience);
					}
			break;

			case "editExperience":
	        		$objExperience->id = isset($_GET['id'])?$_GET['id']:'';			
					getRecord($objDb,$objSession,$objExperience);
			break;

			case "deleteExperience":
	        		$objExperience->id = isset($_GET['id'])?$_GET['id']:'';			
					deleteRecord($objDb,$objSession,$objExperience);
			break;
			case "addShow":
			        setShowValues($objDb,$objSession,$objShow);
					if($objShow->id == 0){
						//echo "Going to call addExperience ";
 					    addShow($objDb,$objSession,$objShow);
					}
					else{
						//echo "Going to call updateExperience ";
 					    updateShow($objDb,$objSession,$objShow);
					}
			break;

			case "deleteShow":
	        		$objShow->id = isset($_GET['id'])?$_GET['id']:'';			
					deleteRecord($objDb,$objSession,$objShow);
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
		$objExperience->start_month = isset($_GET['start_month'])?$_GET['start_month']:'';
		$objExperience->end_month = isset($_GET['end_month'])?$_GET['end_month']:'';
		$objExperience->start_year = isset($_GET['start_year'])?$_GET['start_year']:'';
		$objExperience->end_year = isset($_GET['end_year'])?$_GET['end_year']:'';
		$objExperience->job_description = isset($_GET['job_description'])?$_GET['job_description']:'';
		$objExperience->user_id = $objSession->id;
	}

    function setShowValues($objDb,$objSession,$objShow){

   		$objShow->id = isset($_GET['id'])?$_GET['id']:'';
		$objShow->show_name = isset($_GET['show_name'])?$_GET['show_name']:'';
		$objShow->show_duration = isset($_GET['show_duration'])?$_GET['show_duration']:'';
		$objShow->show_cost = isset($_GET['show_cost'])?$_GET['show_cost']:'';
		$objShow->show_time = isset($_GET['show_time'])?$_GET['show_time']:'';
		$objShow->show_date = isset($_GET['show_date'])?$_GET['show_date']:'';
		$objShow->media_type_id = isset($_GET['media_type'])?$_GET['media_type']:'';
		$objShow->show_description = isset($_GET['show_description'])?$_GET['show_description']:'';
		$objShow->user_id = $objSession->id;
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

	          echo "sucadd<tr id=row_".$last_id.">
                <td>  <a id='edit-edu' onClick=edit(".$last_id.")> Edit</a>  <a  onClick=deleteRow(".$last_id.")> Delete</a> </td>
                <td>  ".$objEducation->start_year." </td>
                <td>  ".$objEducation->end_year ."  </td>
                <td>  ".$objEducation->school ."</td> 
                <td> ".$objEducation->degree.' '.$objEducation->subject."</td>
                                                               
            </tr>";
			}
			else{
					$objSession->setSessMsg("Record not inserted inderted...");	
					//echo "Record not inderted successfully...";			
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

	          echo "sucadd<tr id=row_".$last_id.">
                <td>  <a id='edit-edu' onClick=editExperience(".$last_id.")> Edit</a>  <a  onClick=deleteExperience(".$last_id.")> Delete</a> </td>
                <td>  ".$objExperience->start_year." </td>
                <td>  ".$objExperience->end_year ."  </td>
                <td>  ".$objExperience->company ."</td> 
                <td> ".$objExperience->job_title."</td>
                                                               
            </tr>";
			}
			else{
					$objSession->setSessMsg("Record not inserted inderted...");	
					//echo "Record not inderted successfully...";			
			}
		}

	}
	


    function addShow($objDb,$objSession,$objShow){
		//echo $error = $objEducation->validate();
		echo "<br> Query :: ".$objShow->Add();
		if(empty($error)){
			if( $objDb->execute($objShow->Add())){
			  $last_id = $objDb->insert_id();
		 	  $objSession->setSessMsg("Record inderted successfully...");
	          echo "sucadd<tr id=row_".$last_id.">
                <td>  <a id='edit-edu' onClick=edit(".$last_id.")> Edit</a>  <a  onClick=deleteRow(".$last_id.")> Delete</a> </td>
                <td>  ".$objShow->show_name." </td>
                <td>  ".$objShow->show_date .' '.$objShow->show_date ." </td>
                <td>  ".$objShow->media_type_id ."</td> 
                                                               
            </tr>";
			}
			else{
					$objSession->setSessMsg("Record not inserted inderted...");	
					//echo "Record not inderted successfully...";			
			}
		}

	}
	


	function getRecord($objDb,$objSession,$obj){

           	$sql = $obj->PopulateGrid("*"," AND id= ".$obj->id);  
			$record = $objDb->getArraySingle($sql);
            echo json_encode($record);
 		
	}

   function updateEducation($objDb,$objSession,$objEducation){
		//echo $error = $objEducation->validate();
		//echo "<br> Query :: ".$objEducation->Update();
		if(empty($error)){
			if( $objDb->execute($objEducation->Update())){
   					$objSession->setSessMsg("Record updated successfully...");
					if($objEducation->start_month ==0)$objEducation->start_month="present";
					if($objEducation->start_year ==00)$objEducation->start_year="present";
					if($objEducation->end_month ==0)$objEducation->end_month="present";
					if($objEducation->end_year ==00)$objEducation->end_year="present";

 	                echo "sucupd<td>  <a id='edit-edu' onClick=edit(".$objEducation->id.")> Edit</a>  <a  onClick=deleteRow(".$objEducation->id.")> Delete</a> </td>
						<td> ".$objEducation->start_year." </td>
						<td> ".$objEducation->end_year ."  </td>
						<td> ".$objEducation->school ."</td> 
						<td> ".$objEducation->degree.' '.$objEducation->subject."</td>";
			}
			else{
					$objSession->setSessMsg("Record not updated ...");	
			}
		}

	}


   function updateExperience($objDb,$objSession,$objExperience){
		//$error = $objExperience->validate();
		if(empty($error)){
			if( $objDb->execute($objExperience->Update())){
   					$objSession->setSessMsg("Record updated successfully...");
					if($objExperience->start_month ==0)$objExperience->start_month="present";
					if($objExperience->start_year ==00)$objExperience->start_year="present";
					if($objExperience->end_month ==0)$objExperience->end_month="present";
					if($objExperience->end_year ==00)$objExperience->end_year="present";

 	                echo "sucupd<td>  <a id='edit-edu' onClick=editExperience(".$objExperience->id.")> Edit</a>  <a  onClick=deleteExperience(".$objExperience->id.")> Delete</a> </td>
						<td>  ".$objExperience->start_year." </td>
						<td>  ". $objExperience->end_year ."  </td>
						<td>  ".$objExperience->company ."</td> 
						<td> ".$objExperience->job_title."</td>";
					
			}
			else{
					$objSession->setSessMsg("Record not updated ...");	
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