<?php 
include('../settings/settings.php');
include('../helpers/helper.php');
fckInclude();
$objSession = new Session(CLIENT_ROLE_MEDIA);
$objSession->checkSession(CLIENT_ROLE_MEDIA,"../index.php") ;

$objDb = new Database();
$objDb->connect();
#printArray($objSession);
//exit;
$jobId=isset($_GET['job']) ? intval($_GET['job']) : '';
$objJobPost = new JobPost();
$sqlJobPost = $objJobPost->PopulateGrid("*",' AND status = 1 and id='.$jobId,'');  
$job_Array = $objDb->getArraySingle($sqlJobPost); 

$objJobAppFile = new JobAppFile();
$sqlJobApp = $objJobAppFile->PopulateGrid("*",' AND status = 1 and file_type_id='.$jobId,'');  
$jobApp_Array = $objDb->getArraySingle($sqlJobApp); 

$objCategory=new Categories();
$sqlCategory = $objCategory->PopulateGrid("id,title",' AND status = 1 ','order by title asc');  
$cat_Array = $objDb->getArray($sqlCategory);

#$sql = $objUser->PopulateGrid("*"," AND id= ".$objSession->id);  
#$userInfo = $objDb->getArraySingle($sql);
if($_POST['postjobbtn'])
{
	#printArray($_POST);
	#printArray($_FILES);
	#print_r($_FILES);
	#exit;
	$id = isset($_POST['id'])? doubleval($_POST['id']):'';
	$budget = isset($_POST['budget'])? doubleval($_POST['budget']):'';
	$lastDate = isset($_POST['last_date'])?$_POST['last_date']:'';
	$mediaId=isset($_POST['media_id'])? intval($_POST['media_id']):'';
	$jobTitle=isset($_POST['job_title'])?$_POST['job_title']:'';
	$jobDesc=isset($_POST['job_desc'])?$_POST['job_desc']:'';
	$location=isset($_POST['location'])?$_POST['location']:'';
	
	#$agree = isset($_POST['agree'])?$_POST['agree']:'';
	$objJobPost->id = $id;	
	$objJobPost->job_title = $jobTitle;
	$objJobPost->job_desc = $jobDesc;
	$objJobPost->budget = $budget;
	$objJobPost->media_id = $mediaId;
	$objJobPost->last_date = $lastDate;
	$objJobPost->location = $location;
	$objJobPost->status = 1;
	$objJobPost->user_id = $objSession->id;
	$error .= $objJobPost->validate();
	#echo $error.'aa';
	if(empty($error))
	{
			if($_FILES['docFile']['name']!="")	
				{
					if($_FILES['docFile']['error']==0)	
					{
						
						$allowExt = array('image/jpeg','image/png','image/gif','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','text/css','text/plain');
				//printArray($allowExt); exit; 
				
						if(hlpValidImage('docFile',$allowExt))
						{
							#echo 'here';exit;;
							 	hlpMakeDir(ADMIN_PREFIX.SITEDATA_DIR);
      							hlpMakeDir(ADMIN_PREFIX.SITEDATA_DIR.USER_POST_DIR);
      
     							$objJobAppFile->file_name  = SITEDATA_DIR.USER_POST_DIR.''.hlpUploadFile('docFile',ADMIN_PREFIX.SITEDATA_DIR.USER_POST_DIR);
      							$objJobAppFile->status = 1;
//      printArray($objJobAppFile);      echo $objJobAppFile->Add();exit;
									if($objDb->execute($objJobPost->Update()))
										{
											$objJobAppFile->file_type = 1;
											$objJobAppFile->file_type_id =$id;
											$objJobAppFile->id = isset($_POST['job-app-id']) ? intval($_POST['job-app-id']) : '';
											#echo $objJobAppFile->Add();exit;
										 if($objDb->execute($objJobAppFile->Update()))
											{
			   //echo 'here';exit;;
											$objSession->setSessMsg('Post has been Updated successfully.');       
											$objSession->redirectTo(SITE_ROOT.'media/my-posts.php');       
											}
										}
						}
					}
				else
					$error .= '&nbsp;&bull;&nbsp;File size should be 5MB.<br>';
				}
			else
			{
				$objDb->execute($objJobPost->Update());
				$objSession->setSessMsg('Post has been Updated successfully.');
				$objSession->redirectTo(SITE_ROOT.'media/my-posts.php'); 
			}
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/lib/jquery.js"></script>
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
  <form method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="userType" id="userType" value="4">

   <div id="form-warrper"> 
   
    <?php include("../includes/err-succ-info.php");  ?>   
    
    <div class="form-head">  
    	<h3> Post a job</h3> 
    </div>
   
    <div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Budget </label> </div>     
     <div class="col-two"> 
     <input type="text" style="width:100px" id="budget" name="budget" value="<?=$job_Array['budget']?>"> $
     <p class="upfront-payment"> Limit your risk by requesting an upfront payment.</p>
     </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Last Date </label> </div>     
     <div class="col-two">
     <input type="text" maxlength="10" name="last_date" id="last_date" value="<?=date('Y-m-d',strtotime($job_Array['last_date']))?>"  />
       
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Category </label> </div>     
     <div class="col-two">
     
     <select name="media_id" id="media_id" >
     <? foreach($cat_Array as $key=>$value){ ?>
     <option value="<?=$value['id']?>" <?=$job_Array['media_id']==$value['id'] ? 'selected="selected"' : ''?>><?=$value['title']?></option>
     <? } ?>
     </select>
       
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Job Title </label> </div>     
     <div class="col-two">
     <input type="text" maxlength="10" name="job_title" id="job_title" value="<?=$job_Array['job_title']?>"  />
       
     </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Description </label> </div>     
     <div class="col-two"> 
     <?php
                                            $oFCKeditor = new FCKeditor('job_desc',"custom");
                                            $oFCKeditor->BasePath = SITE_ROOT."FCKeditor/";
                                            $oFCKeditor->Value= hlpHtmlSlashes($job_Array['job_desc']);
                                            $oFCKeditor->Height=350;
                                            $oFCKeditor->Width=700;
                                            $oFCKeditor->Create();
                                        ?>
      
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Address </label> </div>     
     <div class="col-two"> 
     <textarea name="location" id="location" cols="120" rows="10"><?=$job_Array['location']?></textarea>
      
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Attachment </label> </div>     
     <div class="col-two" style="width: 270px;"> 
     <input type="file" name="docFile" id="docFile"><?=$jobApp_Array['file_name']?>
     <p class="upfront-payment"> File size should be less than 5MB. Include work sample or other documents to suppot your application. Do not attach your resume. </p>   
     </div>
     <div class="error"></div>
    </div>
    
    
 
    <div class="submit-btn"><input type="hidden" name="id" value="<?=$job_Array['id']?>" />
    <input type="hidden" name="job-app-id" value="<?=$jobApp_Array['id']?>" />
     <input type="submit" value="Update" name="postjobbtn">
    </div>
    
   </div> <!-- form warrper -->

  </form>
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
