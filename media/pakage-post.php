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
$objPakagePost = new PakagePost();
$objJobAppFile = new JobAppFile();

$objMedia=new MediaType();
$sqlMedia = $objMedia->PopulateGrid("id,title",' AND status = 1 ','order by title asc');  
$media_Array = $objDb->getArray($sqlMedia);

#$sql = $objUser->PopulateGrid("*"," AND id= ".$objSession->id);  
#$userInfo = $objDb->getArraySingle($sql);
if($_POST['postpakagebtn'])
{
	printArray($_POST);
	#printArray($_FILES);
	#print_r($_FILES);
	
	$budget = isset($_POST['budget'])? doubleval($_POST['budget']):'';
	$lastDate = isset($_POST['last_date'])?$_POST['last_date']:'';
	$mediaId=isset($_POST['media_id'])? intval($_POST['media_id']):'';
	$jobTitle=isset($_POST['pakage_title'])?$_POST['pakage_title']:'';
	$jobDesc=isset($_POST['pakage_desc'])?$_POST['pakage_desc']:'';
	$duration=isset($_POST['duration'])?$_POST['duration']:'';
	
	$agree = isset($_POST['agree'])?$_POST['agree']:'';	
	$objPakagePost->pakage_title = $jobTitle;
	$objPakagePost->pakage_desc = $jobDesc;
	$objPakagePost->budget = $budget;
	$objPakagePost->media_id = $mediaId;
	$objPakagePost->last_date = $lastDate;
	$objPakagePost->duration = $duration;
	$objPakagePost->status = 1;
	$objPakagePost->user_id = $objSession->id;
	$error .= $objPakagePost->validate();
	#echo $error.'aa';
	if(empty($error))
	{
		if($objDb->GetCountSql($objPakagePost->table," AND pakage_title='".$jobTile."' and budget=$budget and media_id=$mediaId and last_date='$lastDate'")>0)
			$error .= '&nbsp;&bull;&nbsp;Email already exists.<br>';
			
			if(empty($error))
			{
				
				/*if($_FILES['docFile']['name']!="")	
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
									if($objDb->execute($objJobPost->Add()))
										{
											$objJobAppFile->file_type = 1;
											$objJobAppFile->file_type_id = $objDb->insert_id();
											#echo $objJobAppFile->Add();exit;
										 if($objDb->execute($objJobAppFile->Add()))
											{
			   //echo 'here';exit;;
											$objSession->setSessMsg('Post has been Adeed successfully.');       
											$objSession->redirectTo(SITE_ROOT.'media/my-posts.php');       
											}
										}
						}
					}
				else
					$error .= '&nbsp;&bull;&nbsp;File size should be 5MB.<br>';
				}
			else*/
				if($objDb->execute($objPakagePost->Add()))
				{
				$objSession->setSessMsg('Pakage has been applied successfully.');
				$objSession->redirectTo(SITE_ROOT.'media/my-pakage-posts.php'); 
				}
				else
				{
					$error .= '&nbsp;&bull;&nbsp;Pakage not added.<br>';
				}
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
    	<h3> Post a Pakage</h3> 
    </div>
   
    <div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Budget </label> </div>     
     <div class="col-two"> 
     <input type="text" style="width:100px" id="budget" name="budget"> $
     <p class="upfront-payment"> Limit your risk by requesting an upfront payment.</p>
     </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Last Date </label> </div>     
     <div class="col-two">
     <input type="text" maxlength="10" name="last_date" id="last_date" value="<?=date('Y-m-d')?>"  />
       
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Media </label> </div>     
     <div class="col-two">
     
     <select name="media_id" id="media_id" >
     <? foreach($media_Array as $key=>$value){ ?>
     <option value="<?=$value['id']?>"><?=$value['title']?></option>
     <? } ?>
     </select>
       
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Pakage Title </label> </div>     
     <div class="col-two">
     <input type="text" maxlength="10" name="pakage_title" id="job_title" value=""  />
       
     </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Description </label> </div>     
     <div class="col-two"> 
     <?php
                                            $oFCKeditor = new FCKeditor('pakage_desc',"custom");
                                            $oFCKeditor->BasePath = SITE_ROOT."FCKeditor/";
                                            $oFCKeditor->Value= hlpHtmlSlashes($job_desc);
                                            $oFCKeditor->Height=350;
                                            $oFCKeditor->Width=700;
                                            $oFCKeditor->Create();
                                        ?>
      
     </div>
     <div class="error"></div>
    </div>
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Duration </label> </div>     
     <div class="col-two"> 
     <input type="text" name="duration" id="duration" value="" placeholder="Time in Second" />
      
     </div>
     <div class="error"></div>
    </div>
    <!--<div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Attachment </label> </div>     
     <div class="col-two" style="width: 270px;"> 
     <input type="file" name="docFile" id="docFile">
     <p class="upfront-payment"> File size should be less than 5MB. Include work sample or other documents to suppot your application. Do not attach your resume. </p>   
     </div>
     <div class="error"></div>
    </div>-->
    
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Agree to Terms </label> </div>     
     <div class="col-two" style="width: 270px;"> 
     <p class="upfront-payment"> <input type="checkbox"> I understanding and agree to the User Agreement and Incorporated polices. </p>   
     </div>
     <div class="error"></div>
    </div>
 
    <div class="submit-btn">
     <input type="submit" value="Save" name="postpakagebtn">
    </div>
    
   </div> <!-- form warrper -->

  </form>
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
