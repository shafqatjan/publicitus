<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_EXPERT);
$objSession->checkSession(CLIENT_ROLE_EXPERT,"../index.php") ;

$objDb = new Database();
$objDb->connect();
$objCat = new Categories();
$objMediaType = new MediaType();
$objUser = new User();
$objUserCategoriesMap = new UserCategoriesMap();

$sql = $objUser->PopulateGrid("*"," AND id= ".$objSession->id);  
$userInfo = $objDb->getArraySingle($sql);

$firstName 				= $userInfo['first_name'];
$lastName 				= $userInfo['last_name'];
$email 					= $userInfo['email'];
$company 				= $userInfo['company'];
$website 				= $userInfo['website'];
$address 				= $userInfo['address'];
$phone 					= $userInfo['phone'];
$cell 					= $userInfo['cell'];
$city 					= $userInfo['city'];
$state 					= $userInfo['state'];
$zipCode 				= $userInfo['zipcode'];
$country 				= $userInfo['country'];

$sqlUserCat = $objUserCategoriesMap->PopulateGrid("category_id"," AND status = 1 AND user_id= ".$objSession->id);  
$error = '';

$sqlAllCat = $objCat->PopulateGrid("*"," AND id IN (".$sqlUserCat.") AND status = 1 ")." order by title";  
$cat_Array = $objDb->getArray($sqlAllCat);
//printArray($cat_Array);


?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title>Publicitus</title>
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
  
   <div id="profile-warrper">
   
    <div class="profile-blue-box"> <!-- first blue box -->
    
           <div class="profile-blue-first"> <!-- blue box first row -->
            <span class="profile-blue-heading"> <h3> <?php echo $firstName.' '.$lastName;?> </h3> </span>
            <span class="profile-blue-close-btn">  </span>
           </div> <!-- blue box first row -->
     
           <div class="profile-blue-second"> <!-- blue box Second row --> 
     <?php 
             		  
	if(count($cat_Array)>0)
	{
		foreach($cat_Array as $Data_row)
		{
		
	?>
             <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
              <span class="profile-blue-second-btn-text"> <?php echo $Data_row['title'];?> </span>
              <span class="profile-blue-second-btn-close">  </span>
             </div> <!-- fisrt blue box Skill button --->               
         <?php }}?>
         </div> <!-- blue box second row -->
     <!--
         <div class="profile-blue-third"> 
         
          <span class="blue-box-endorse-btn"> <input type="button" value="Endorse"> </span>
          <span class="blue-box-skip-btn"> <input type="button" value="skip"> </span>
          <span class="blue-box-what-is-this"> <a href="#">  </a> </span>
         
         </div> -->
    
    </div> <!-- first blue box -->

    
    <div class="profile-second-white-box">
    
    <div class="profile-photo"> <!-- profile photo -->  </div>
    
    <div class="profile-name"> 
   
    <div class="profile-display-name"> <h2>  <?php echo $firstName.' '.$lastName;?> </h2> </div>
    <div class="profile-profession"> <h4> Research Student at Southeast University </h4> </div>
    <div class="profile-company-address"> <p> China | Mechanical or Industrial Engineering </p> </div>
    <div class="privious-job"> 
     <span class="privious-heading"> <p class="job-heading"> Privious </p> </span>
     <span class="privious-job-detial"> <p class="job-detail">  MySuperTicket, Fauji Fertilizer Company Limited </p>     </span>
    </div>
    
    <div class="privious-job"> 
     <span class="privious-heading"> <p class="job-heading"> Education </p> </span>
     <span class="privious-job-detial"> <p class="job-detail"> Southeast University </p> </span>
    </div>
     
    <div class="send-message">
    
      <span class="send-message-btn">
       <input type="button" value="Send a messae">
      </span>
    
    </div> 
     
    </div> <!-- profile-name -->
    
    <div class="profile-cost"> 
     <span class="cost-price"> $125/hr </span>
    </div>
         
    </div> <!-- profile-second-white-box -->
    
    <div class="profile-third-white-box">
    
   <!-- <div class="profile-background"> Background </div> -->
    
    <div class="profile-third-box-detail">
    
    <div class="eductaion-heading">
     <h3 class="background-heading"> Media Sought</h3>
    </div>
    
    <div class="education-detail">
     
      <h4> SouthEast University </h4>
      <p class="degree-detail"> Master of Science (MS), Mechatronic Engineering </p> 
      <p class="degree-year"> 2010 - 2014 (expeted) </p>
      <p class="degree-decribtion"> I am doing master degree at Southeast University </p>
    
    </div>
   
    </div>
    
     <div class="profile-third-box-detail">
    
    <div class="eductaion-heading">
     <h3 class="background-heading"> Education </h3>
    </div>
    
    <div class="education-detail">
     
      <h4> SouthEast University </h4>
      <p class="degree-detail"> Master of Science (MS), Mechatronic Engineering </p> 
      <p class="degree-year"> 2010 - 2014 (expeted) </p>
      <p class="degree-decribtion"> I am doing master degree at Southeast University </p>
    
    </div>
    
      <div class="education-detail">
     
      <h4> SouthEast University </h4>
      <p class="degree-detail"> Master of Science (MS), Mechatronic Engineering </p> 
      <p class="degree-year"> 2010 - 2014 (expeted) </p>
      <p class="degree-decribtion"> I am doing master degree at Southeast University </p>
    
    </div>
   
    </div>
    
    </div> <!-- profile-third-white-box -->
    
   </div> <!-- profile warrper -->
 
  </div> <!-- content -->
  
  <!-- footer -->
    <?php include('../includes/footer.php');?>
   
 </div> <!-- Warpper -->



</body>
</html>
