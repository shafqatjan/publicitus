<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_MEDIA);
$objSession->checkSession(CLIENT_ROLE_MEDIA,"../index.php") ;

$objDb = new Database();
$objDb->connect();
$objCal = new Calander();
$sdate = isset($_GET['date'])?$_GET['date']:'';
$sqlAllCat = $objCal->PopulateGrid("*"," AND which_date = '".$sdate."' AND status = 1 AND user_id=".$objSession->id)." order by title";  
$cat_Array = $objDb->getArray($sqlAllCat);
//printArray($cat_Array);

$t = time();
$current_year = date('Y',$t);
		 

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">

<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/modernizr.js"></script>
<script src="../js/lib/jquery.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

    <style>
        body { font-size: 62.5%; }
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>



<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/modernizr.js"></script>

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
        <?php include("../includes/err-succ-info.php");  ?>
     <!-- profile blue box -->   
    
    

       <!-- profile-third-white-box -->
<div class="profile-third-white-box">
    
    <div class="profile-background"> Callander </div>
    
    <div class="profile-third-box-detail">
    
    <div class="eductaion-heading">
     <h3 class="background-heading"> Todays Schedule (<?=hlpDateFormat($sdate);?>) </h3>
     <span class="add-info">  <span class="blue-box-endorse-btn"> <!--<input type="button" id="add-edu" value="Add Info">--> </span>  </span>
    </div>
    
    <div class="education-detail">

    <?php 
		if(count($cat_Array)>0)
		{
			//printArray($educ_Array);
	?>
     
     <table id="eduTab" class="gridtable">
     
     <tr>
      <th width="50">Title</th>
      <th width="50">Description</th>
      <th width="200">Which Dated</th>
      <th width="200">Dated Posted</th>
     </tr>
     
		<?php 
			foreach($cat_Array as $Data_row)
			{
		?>
            <tr id="row_<?=$Data_row['id'];?>">
                <td>  <?php echo $Data_row['title'];?> </td>
                <td>  <?php echo nl2br($Data_row['description']);?>  </td>
                <td>  <?php echo hlpDateFormat($Data_row['which_date']);?> </td> 
                <td>  <?php echo hlpDateTimeFormat($Data_row['dated']);?> </td>
                                                               
            </tr>
            <?php } //enf foreach?>
    </table>
    <?php } //end if?>
    
   
    </div>
</div>
  


 <!-- popup-box -->
  </div> <!-- popup-box-warpper -->
  
  <!-- edid education dialog -->
  <!----> <!-- popup-box-warpper -->

 <!-- popup-box-warpper -->  
    </div><!-- profile-third-white-box -->

    </div>  
    <!-- profile warrper -->
        <?php include('../includes/footer.php');?>

 </div> <!-- content -->

   
</div>
  
  <!-- Wraper -->



</body>
</html>
