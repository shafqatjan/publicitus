<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


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
//printArray($jobInfoArray);
$yourrate = '';
$coverletter = '';
$agree='';
$error ='';
if($_POST['applybtn'])
{
	printArray($_POST);
	printArray($_FILES);
	$yourrate = isset($_POST['yourrate'])?$_POST['yourrate']:'';
	$coverletter = isset($_POST['coverletter'])?$_POST['coverletter']:'';
	$agree = isset($_POST['agree'])?$_POST['agree']:'';	
	$objJobApplication->user_rate = $yourrate;
	$objJobApplication->user_cover_latter = $coverletter;
	$error .= $objJobApplication->validate();
	if(empty($error))
	{
		if($_FILES['file']['name']!="")	
		{
			if($_FILES['file']['error']==0)	
			{
				$allowExt = array('image/jpeg','image/png','image/gif','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','text/css','text/plain');
				//printArray($allowExt); exit; 
				
				if(hlpValidImage('file',$allowExt))
				{
					echo 'here';exit;;
					hlpMakeDir(ADMIN_PREFIX.SITEDATA_DIR);
					hlpMakeDir(ADMIN_PREFIX.SITEDATA_DIR.USER_APPLY_DIR);
				}
			}
			else
				$error .= '&nbsp;&bull;&nbsp;File size should be 5MB.<br>';
		}
		else
			$error .= '&nbsp;&bull;&nbsp;Please select file.<br>';
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
    	<h3> Apply For Post </h3> <a href="job-detail.php?job=<?php echo $jobId;?>"> View Job Posting </a>
    </div>
   
    <div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Your Rate </label> </div>     
     <div class="col-two"> 
     <input type="text" style="width:100px" id="yourrate" name="yourrate" value="<?php echo $yourrate;?>"> Job Rate $<?php echo $jobInfoArray['budget'];?>
     <p class="upfront-payment"> Enter your rate against the job rate.</p>
     </div>
     <div class="error"></div>
    </div>
    
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Cover Letter </label> </div>     
     <div class="col-two"> 
     <textarea style="height:200px;" id="coverletter" name="coverletter"><?php echo $coverletter;?></textarea>     
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
     <input type="submit" value="Sign In" id="applybtn" name="applybtn">
    </div>
    
   </div> <!-- form warrper -->
  </form>
  
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
