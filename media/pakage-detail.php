<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session();
$objDb = new Database();

$objDb->connect();
$objUser = new User();
$objPakagePost = new PakagePost();
$pakageId=isset($_GET['pakage']) ? intval($_GET['pakage']) : '';
$sqlPakagePost = $objPakagePost->PopulateGrid("*",' AND status = 1 and id='.$pakageId)."";  
$pakage_array = $objDb->getArraySingle($sqlPakagePost);
#printArray($pakage_array);
$mediaId=!empty($pakage_array['media_id']) ? intval($pakage_array['media_id']) : '';


$objMedia=new MediaType();
$media_Title = $objDb->get_record($objMedia->table,"title", 'status = 1 and id='.$mediaId,  1);

$objJopApp=new PakageApplication();

 $noOfApp=$objDb->GetCountSql($objJopApp->table,"and pakage_id=".$pakageId);
 $objApplication=new JobApplication();
 $applyJob=$objDb->GetCountSql($objApplication->table,"and user_id=".$objSession->id." and job_id=".$pakageId);;

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title>Publicitus</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/modernizr.js"></script>
<!--[if IE 6]>
<link href="css/IE/style-IE-6.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 7]>
<link href="css/IE/style-IE-7.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8]>
<link href="css/IE/style-IE-8.css" rel="stylesheet" type="text/css">
<![endif]-->

</head>

<body>

 <div id="warpper">
 
  <?php include('../includes/header.php');?>
  
  <div id="content">
  
   <div id="profile-warrper">
    
     <div class="job-detail-page">
     
      <div class="job-detail-page-row-one">
       <div class="job-detail-page-row-one-col"> 
        <a href="<?=SITE_ROOT?>media/my-pakage-posts.php"> &lt; Back to My Post Results </a> </div>
       <div class="job-detail-page-row-one-col" style="text-align:center;"> 
        <!--<a href="#"> Flag as inappropriate </a>--> </div>
       <div class="job-detail-page-row-one-col" style="text-align:right;"> 
       <!--<b> 1 </b> of 5000 <a href="#"> next &gt; </a>--> </div>
      </div>
      
      <div class="job-detail-page-row-two">
      
       <div class="job-detail-page-job-heading-box">
        <div class="job-detail-page-job-heading"> <?=$pakage_array['pakage_title']?> </div>
        <div class="job-detail-page-job-price"> <b> Fixed price Project </b> - Est. Budget $<?=$pakage_array['budget']?> - Posted <?=hlpDateFormat($pakage_array['dated'])?> </div>       </div>
       
       <div class="job-detail-page-apply-btn-box">
        <div class="job-detail-page-apply-btn"><? /*if($applyJob==0){?> <input type="button" value="Apply to this job" onClick="window.location='<?=SITE_ROOT?>expert/apply.php?job=<?=$pakage_array['id']?>'"> <? } */?></div>
        <div class="job-detail-page-apply-btn-detail"> <!--Job applications remaining: 15 of 20--> </div>
       </div>
      
      </div> <!-- job-detail-page-row-two -->
      
      <div class="job-detail-page-row-title"> 
      <div class="job-detail-page-row-title-text"> Pakage Description </div>
      </div>
      
      <div class="job-detail-page-row-description"> 
      
          <div class="job-detail-page-row-job-description"> 
          <?=$pakage_array['pakage_desc']?> 
          </div>
      
          <div class="job-detail-page-skill-required-box">
            <div class="job-detail-page-skill-required-title"> <?=$media_Title?><!--Skills Required--> </div>  
           <!-- <div class="job-detail-page-skill-required-detail"> Wordpress </div>
            <div class="job-detail-page-skill-required-detail"> PHP </div>-->
          </div>
      
          <div class="job-detail-page-skill-required-box">
            <div class="job-detail-page-skill-required-title"> Purchaser Activity on this Job </div>  
                <div class="job-detail-page-skill-required-detail" style="background:none;padding:0px;">
            
              <table class="job-detail-page-tabel">   
                       <!--<tr>
                          <th>
                           Last Viewed:
                          </th>
                          <td>
                           23 minutes ago
                          </td>
                       </tr>-->
                       <tr>
                          <th>
                           Applicants:
                          </th>
                          <td>
                           <?=$noOfApp?>
                          </td>
                       </tr>
                       <!--<tr>
                          <th>
                           Interviewing:
                          </th>
                          <td>
                           0
                          </td>
                       </tr>-->
                        
                       
               </table>
            </div>
          </div>
      
      </div> <!--job-detail-page-row-description-->
      
      
       <div class="job-detail-page-row-title"> 
      <div class="job-detail-page-row-title-text"> Pakage Overview </div>
      </div>
      
      <div class="job-detail-page-row-description"> 
      
          <div class="job-detail-page-skill-required-box">
             
                <div class="job-detail-page-skill-required-detail" style="background:none;padding:0px;">
            
              <table class="job-detail-page-tabel">   
                       <tr>
                          <th>
                           Type:
                          </th>
                          <td>
                           Fixed Price
                          </td>
                       </tr>
                       <tr>
                          <th>
                           Budget:
                          </th>
                          <td>
                           $<?=$pakage_array['budget']?>
                          </td>
                       </tr>
                       <tr>
                          <th>
                           Posted:
                          </th>
                          <td>
                           <?=hlpDateFormat($pakage_array['dated'])?>
                          </td>
                       </tr>
                        <tr>
                          <th>
                           Planned Start:
                          </th>
                          <td>
                           Immediately
                          </td>
                       </tr>
                       <tr>
                          <th>
                           Delivery Date:
                          </th>
                          <td>
                           <?=hlpDateFormat($pakage_array['last_date'])?>
                          </td>
                       </tr>
                       <tr>
                          <th>
                           Visibility:
                          </th>
                          <td>
                           Public

                          </td>
                       </tr>
                       <tr>
                          <th>
                           Category:
                          </th>
                          <td>
                           <?=$media_Title?>

                          </td>
                       </tr>
                       <tr>
                          <th>
                           Duration:
                          </th>
                          <td>
                           <?=($pakage_array['duration'])?>
                          </td>
                       </tr>
                        
                       
               </table>
            </div>
          </div>
      
      </div> <!--job-detail-page-row-description-->
      
       <!--<div class="job-detail-page-row-title"> 
      <div class="job-detail-page-row-title-text"> Client's Work History and Feedback (7) </div>
      </div>-->
      
       <!--<div class="job-detail-page-row-description"> 
      
          <div class="job-detail-page-row-job-description-row"> 
          
           <div class="job-detail-page-row-job-description-row-col-one"> 
             
              <div class="job-detail-page-job-name"> Php Wordpress developer </div>
  
              <div class="job-detail-page-job-progress"> job in progress </div>
  
              <div class="job-detail-page-job-contractor"> Contractor: <a href="#"> Arsen Dabaghyan </a> </div>
             
             </div>
             <div class="job-detail-page-row-job-description-row-col-two"> 
              <div class="job-detail-page-job-name"> sep 2012 -Present </div>
              <div class="job-detail-page-job-name"> <b> 106 hrs @ $16.67/hr </b> </div>
             <div class="job-detail-page-job-name"> Biled: $1,761.46 </div>
             </div>
           
           </div>
           
           <div class="job-detail-page-row-job-description-row"> 
          
           <div class="job-detail-page-row-job-description-row-col-one"> 
             
              <div class="job-detail-page-job-name"> Php Wordpress developer </div>
  
              <div class="job-detail-page-job-progress"> job in progress </div>
  
              <div class="job-detail-page-job-contractor"> Contractor: <a href="#"> Arsen Dabaghyan </a> </div>
             
             </div>
             <div class="job-detail-page-row-job-description-row-col-two"> 
              <div class="job-detail-page-job-name"> sep 2012 -Present </div>
              <div class="job-detail-page-job-name"> <b> 106 hrs @ $16.67/hr </b> </div>
             <div class="job-detail-page-job-name"> Biled: $1,761.46 </div>
             </div>
           
           </div>
           
           
     
      
          
      
      </div>--> <!--job-detail-page-row-description-->
     
     
     </div> <!-- job-detail-page -->
    
   </div> <!-- profile warrper -->

  
  </div> <!-- content -->
  
  <!-- footer -->
  <?php include('includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
