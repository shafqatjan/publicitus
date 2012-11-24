<?php 
include('../settings/settings.php');
include('../helpers/helper.php');
fckInclude();

$objSession = new Session(CLIENT_ROLE_EXPERT);
$objSession->checkSession(CLIENT_ROLE_EXPERT,"../index.php") ;

$objDb = new Database();
$objDb->connect();
$objJobPost = new JobPost();
$objJobApplication = new JobApplication();
$objJobAppFile = new JobAppFile();
$jobId = isset($_GET['job'])?$_GET['job']:'';
//printArray($objSession);
//exit;


$sqlJob = $objJobPost->PopulateGrid("*"," AND id= ".$jobId);  
$jobInfoArray = $objDb->getArraySingle($sqlJob);
$error ='';
$totalApplied = $objDb->GetCountSql($objJobApplication->table, ' AND job_id='.$jobId);
if($totalApplied>0)
	$error .= '&nbsp;&bull;&nbsp;You have already applied for this job.<br>';
//printArray($jobInfoArray);
$yourrate = '';
$coverletter = '';
$agree='';

if($_POST['applybtn'])
{
	if($totalApplied==0)
	{
		//printArray($_POST);
		//printArray($_FILES);
		$yourrate = isset($_POST['yourrate'])?intval(hlpSafeString($_POST['yourrate'])):''; 
		$coverletter = isset($_POST['coverletter'])?htmlspecialchars_decode(hlpSafeString($_POST['coverletter'])):'';

		$agree = isset($_POST['agree'])?$_POST['agree']:'off';	
		$objJobApplication->user_rate = $yourrate;
		$objJobApplication->user_cover_letter = $coverletter;
		$objJobApplication->agree = $agree;
		$error .= $objJobApplication->validate();
		//printArray($objJobApplication);exit;
		if(empty($error))
		{
			$objJobApplication->job_id = $jobId;
			$objJobApplication->user_id = $objSession->id;
			$objJobApplication->status = 1;		
			if($_FILES['file']['name']!="")	
			{
				if($_FILES['file']['error']==0)	
				{
					$allowExt = array('image/jpeg','image/png','image/gif','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','text/css','text/plain','application/vnd.ms-excel');
					//printArray($allowExt); ///exit; 
					
					//if(hlpValidImage('file',$allowExt))
					if(in_array($_FILES['file']['type'],$allowExt))
					{
						//echo $objJobApplication->Add();exit;
						if($objDb->execute($objJobApplication->Add()))
						{
							$objJobAppFile->file_type = 2;
							$objJobAppFile->file_type_id = $objDb->insert_id(); 
							
							
							hlpMakeDir(ADMIN_PREFIX.SITEDATA_DIR);
							hlpMakeDir(ADMIN_PREFIX.SITEDATA_DIR.USER_APPLY_DIR);
							
							$objJobAppFile->file_name  = SITEDATA_DIR.USER_APPLY_DIR.''.hlpUploadFile('file',ADMIN_PREFIX.SITEDATA_DIR.USER_APPLY_DIR);
							$objJobAppFile->status = 1;
	//						printArray($objJobAppFile);						echo $objJobAppFile->Add();exit;
							if($objDb->execute($objJobAppFile->Add()))
							{
								//echo 'here';exit;;
								$objSession->setSessMsg('Job has been applied successfully.');							
								$objSession->redirectTo(SITE_ROOT.'expert/my-jobs.php');
							}
						}
					}
				}
				else
					$error .= '&nbsp;&bull;&nbsp;File size should be 5MB.<br>';
			}
			else
			{
				if($objDb->execute($objJobApplication->Add()))
				{
					$objSession->setSessMsg('Job has been applied successfully.');							
					$objSession->redirectTo(SITE_ROOT.'/expert/my-jobs.php');							
				}			
			}
		}
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/modernizr.js"></script>
<!--[if IE 6]>
<link href="../css/IE/style-IE-6.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 7]>
<link href="../css/IE/style-IE-7.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8]>
<link href="../css/IE/style-IE-8.css" rel="stylesheet" type="text/css">
<![endif]-->

</head>

<body>

 <div id="warpper">
 
  <?php include('../includes/header.php');?>
  
  <div id="content">
  <form method="post" enctype="multipart/form-data">
   <div id="form-warrper"> 
   
    <?php include("../includes/err-succ-info.php");  ?>   
    
    <div class="form-head">  
    	<h3> Apply For Job </h3> <a href="job-detail.php?job=<?php echo $jobId;?>"> View Job Posting </a>
    </div>
   
	<div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Job Rate </label> </div>     
     <div class="col-two"> 
     $<?php echo $jobInfoArray['budget'];?> per minut
     <p class="upfront-payment"></p>
     </div>
     <div class="error"></div>
    </div>   
    <div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Your Rate </label> </div>     
     <div class="col-two"> 
     <input type="text" style="width:100px" id="yourrate" name="yourrate" value="<?php echo $yourrate;?>">
     <p class="upfront-payment"> Enter your rate against the job rate.</p>
     </div>
     <div class="error"></div>
    </div>
    
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Cover Letter </label> </div>     
     <div class="col-two"> 
		<?php
            $oFCKeditor = new FCKeditor('coverletter',"custom");
            $oFCKeditor->BasePath = SITE_ROOT."FCKeditor/";
            $oFCKeditor->Value= html_entity_decode($coverletter);
            $oFCKeditor->Height=350;
            $oFCKeditor->Width=700;
            $oFCKeditor->Create();
        ?>     
<!--     <textarea style="height:200px;" id="coverletter" name="coverletter"><?php echo $coverletter;?></textarea>     -->
     </div>
     <div class="error"></div>
    </div>
    
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Attachment </label> </div>     
     <div class="col-two" style="width: 270px;"> 
     <input type="file" name="file">
     <p class="upfront-payment"> File size should be less than 5MB. Include work sample or other documents to suppot your application. Do not attach your resume. </p>   
     </div>
     <div class="error"></div>
    </div>
    
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Agree to Terms </label> </div>     
     <div class="col-two" style="width: 270px;"> 
     <p class="upfront-payment"> <input type="checkbox" id="agree" name="agree"> I understanding and agree to the User Agreement and Incorporated polices. </p>   
     </div>
     <div class="error"></div>
    </div>
 
    <div class="submit-btn">
     <input type="submit" value="Apply" id="applybtn" name="applybtn" <?php if($totalApplied>0){echo 'disabled="disabled"'; echo 'style="opacity:0.3"';  }?>  >
    </div>
    
   </div> <!-- form warrper -->
  </form>
  
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
