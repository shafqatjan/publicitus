<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_ADVERTISER);
$objSession->checkSession(CLIENT_ROLE_ADVERTISER,"../index.php") ;

$objDb = new Database();
$objDb->connect();
$objJobPost = new PakagePost();
$objJobApplication = new PakageApplication();
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
	#printArray($_POST);
	#printArray($_FILES);
	$agree = isset($_POST['agree'])?$_POST['agree']:'';	
	$objJobApplication->agree = $agree;
	$objJobApplication->pakage_id = $jobInfoArray['id'];
	$objJobApplication->user_id = $objSession->id;
	$error .= $objJobApplication->validate();
	if(empty($error))
	{
		if($objDb->GetCountSql($objJobApplication->table," AND pakage_id='".$jobInfoArray['id']."' and user_id=".$objSession->id)>0)
			$error .= '&nbsp;&bull;&nbsp; already Apply to This Pakage exists.<br>';
			if(empty($error))
			{
			
				if($objDb->execute($objJobApplication->Add()))
				{
				$objSession->setSessMsg('Apply to Pakage has been applied successfully.');
				$objSession->redirectTo(SITE_ROOT.'advertiser/my-pakages.php'); 
				}
				else
				{
					$error .= '&nbsp;&bull;&nbsp;Not Apply to Pakage .<br>';
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
    	<h3> Apply For Pakage </h3> <a href="pakage-detail.php?job=<?php echo $jobId;?>"> View Pakage Posting </a>
    </div>
   
	<div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Pakage Rate </label> </div>     
     <div class="col-two"> 
     $<?php echo $jobInfoArray['budget'];?> per minut
     <p class="upfront-payment"></p>
     </div>
     <div class="error"></div>
    </div>   
    <div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Duration </label> </div>     
     <div class="col-two"> 
     <?php echo $jobInfoArray['duration'];?>
     
     <p class="upfront-payment"> Enter your rate against the job rate.</p>
     </div>
     <div class="error"></div>
    </div>
    
    <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Pakage Title </label> </div>     
     <div class="col-two"> 
     <?php echo $jobInfoArray['pakage_title'];?>     
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
