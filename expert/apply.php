<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_EXPERT);
$objSession->checkSession(CLIENT_ROLE_EXPERT,"../index.php") ;

$objDb = new Database();
$objDb->connect();
//printArray($objSession);
//exit;

//$sql = $objUser->PopulateGrid("*"," AND id= ".$objSession->id);  
//$userInfo = $objDb->getArraySingle($sql);
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
  
   <div id="form-warrper"> 
   
    <?php include("../includes/err-succ-info.php");  ?>   
    
    <div class="form-head">  
    	<h3> Apply For Post </h3> <a href="#"> View Job Posting </a>
    </div>
   
    <div class="two-col" style="text-align:left;margin: 15px 0;">
     <div class="col-one"> <label> Your Rate </label> </div>     
     <div class="col-two"> 
     <input type="text" style="width:100px"> $
     <p class="upfront-payment"> Limit your risk by requesting an upfront payment.</p>
     </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Estimated Duration </label> </div>     
     <div class="col-two"> 
     <select> <option> Select the value </option> </select>      
     </div>
     <div class="error"></div>
    </div>
    
     <div class="two-col" style="text-align:left;">
     <div class="col-one"> <label> Cover Letter </label> </div>     
     <div class="col-two"> 
     <textarea style="height:200px;"> </textarea>     
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
     <p class="upfront-payment"> <input type="checkbox"> I understanding and agree to the User Agreement and Incorporated polices. </p>   
     </div>
     <div class="error"></div>
    </div>
 
    <div class="submit-btn">
     <input type="submit" value="Sign In">
    </div>
    
   </div> <!-- form warrper -->

  
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
