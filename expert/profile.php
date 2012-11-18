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
$objEducation = new Education();
$objExperience = new Experience();

$objUserCategoriesMap = new UserCategoriesMap();

$sql = $objUser->PopulateGrid("*"," AND id= ".$objSession->id);  
$userInfo = $objDb->getArraySingle($sql);
//Query to get education
$sqlEduc = $objEducation->PopulateGrid("*"," AND status = 1  AND user_id= ".$objSession->id); 
$educ_Array = $objDb->getArray($sqlEduc);

//Query to get experience
$sqlExp = $objExperience->PopulateGrid("*"," AND status = 1 AND  user_id= ".$objSession->id); 
$exp_Array = $objDb->getArray($sqlExp);




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
$rate 				    = $userInfo['rate'];

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
<<<<<<< HEAD
<title>Publicitus</title>
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
    <script>
    jQuery(function() {
        var name = jQuery( "#name" ),
            email = jQuery( "#email" ),
            password = jQuery( "#password" ),
            allFields = jQuery( [] ).add( name ).add( email ).add( password ),
            tips = jQuery( ".validateTips" );
 
        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
 
        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }
 
        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
 
        jQuery( "#edu-dialog-form" ).dialog({
            autoOpen: false,
            height: 400,
            width: 400,
            modal: true,
            buttons: {
                "Add": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
  					alert("inside if :: "+bValid);
 
                    bValid = bValid && checkLength( degree, "degree", 3, 16 );
 					alert("afret degree "+bValid);

                    bValid = bValid && checkLength( subject, "subject", 6, 80 );
					alert("afret subject "+bValid);
                    bValid = bValid && checkLength( start_date, "start_date", 5, 16 );
					alert("afret start_date "+bValid);
                    bValid = bValid && checkLength( school, "school", 3, 16 );
					alert("afret school "+bValid);

                    if ( bValid ) {
					var roleCatId=jQuery("#roleCatId").val();
					param =  "action=addEducation";
					alert("param :: "+param);
					//jQuery('#roleSubCatDropDiv').html('');	
					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: '../ajax/action.php',
							   success 	: function(msg)
							   {
									alert("Response msg :: "+msg);
									//jQuery('#roleSubCatDropDiv').html(msg);
							   }
						});
                        jQuery( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    jQuery( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
 //add expeience
 
         jQuery( "#exper-dialog-form" ).dialog({
            autoOpen: false,
            height: 500,
            width: 600,
            modal: true,
            buttons: {
                "Add": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
 
                    bValid = bValid && checkLength( job_title, "job_title", 2, 20 );
                    bValid = bValid && checkLength( company, "company", 2, 80 );
                    bValid = bValid && checkLength( start_date, "start_date", 1, 30 );
 
                    if ( bValid ) {
                        jQuery( "#users tbody" ).append( "<tr>" +
                            "<td>" + job_title.val() + "</td>" + 
                            "<td>" + company.val() + "</td>" + 
                            "<td>" + start_date.val() + "</td>" +
                            "<td>" + start_date.val() + "</td>" +
                        "</tr>" ); 
                        jQuery( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    jQuery( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
		
 
// end add experience
        jQuery( "#add-exper" )
            .button()
            .click(function() {
                jQuery( "#exper-dialog-form" ).dialog( "open" );
            });
        jQuery( "#add-edu" )
            .button()
            .click(function() {
                jQuery( "#edu-dialog-form" ).dialog( "open" );
            });


   });
		$(function() {
           $( "#start_date" ).datepicker();
        });

		$(function() {
           $( "#end_date" ).datepicker();
        }); 

		$(function() {
           $( "#str_date" ).datepicker();
        });

function selectDate(id){
	alert(id);
	 $( id ).datepicker();
}

    </script>

=======
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/modernizr.js"></script>
>>>>>>> 9952f1c64c7adbaf049a88443e6dc5605529b10f
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
 
    </div> <!-- profile blue box -->   
    
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
     
     </div> <!-- profile-name -->
     <div class="profile-cost"> 
         <span class="cost-price"><?php echo $rate .'$'; ?>/min </span> 
         <div class="send-message">
           <span class="send-message-btn"><input type="button" value="Edit" onClick="window.location='edit-profile.php'"></span>
        </div> 

     
     </div>
  </div>

       <!-- profile-third-white-box -->
<div class="profile-third-white-box">
    
    <div class="profile-background"> Background </div>
    
    <div class="profile-third-box-detail">
    
    <div class="eductaion-heading">
     <h3 class="background-heading"> Education </h3>
     <span class="add-info">  <span class="blue-box-endorse-btn"> <input type="button" value="Add Info"> </span>  </span>
    </div>
    
    <div class="education-detail">

    <?php 
		if(count($educ_Array)>0)
		{
			//printArray($educ_Array);
	?>
     
     <table class="gridtable">
     
     <tr>
      <th>Action</th>
      <th>From</th>
      <th>To</th>
      <th>School</th>
      <th>Degree</th>
     </tr>
     
		<?php 
			foreach($educ_Array as $Data_row)
			{
		?>
            <tr>
                <td>  <a href="action=edit&id=<?php echo $Data_row['id'];?>" > Edit</a>  <a href="action=edit&id=<?php echo $Data_row['id'];?>" > Delete</a> </td>

                <td>  <?php echo $Data_row['start_date'];?> </td>
                <td>  <?php echo $Data_row['end_date'];?> </td>
                <td>  <?php echo $Data_row['school'];?> </td> 
                <td>  <?php echo $Data_row['degree'].' '.$Data_row['subject'];?> </td>
                                                               
            </tr>
            <?php } //enf foreach?>
    </table>
    <?php } //end if?>
    
   
    </div>
</div>
  <div class="profile-third-box-detail">
    
       <div class="eductaion-heading">
         <h3 class="background-heading"> Experience </h3>
         <span class="add-info">  <span class="blue-box-endorse-btn"> <input type="button" value="Add Info"> </span>  </span>
        </div>
        
    <div class="education-detail">

    <?php 
		if(count($exp_Array)>0)
		{
			//printArray($exper_Array);
	?>
     
       <table class="gridtable">
     
     <tr>
      <th>Action</th>
      <th>From</th>
      <th>To</th>
      <th>Company</th>
      <th>Time/role</th>
     </tr>     
		<?php 
			foreach($exp_Array as $Data_row)
			{
		?>
     
     <tr>
      	<td> <a href="action=edit&id=<?php echo $Data_row['id'];?>" > Edit </a><p> <a href="action=edit&id=<?php echo $Data_row['id'];?>" > Delete</a></p> </td>
      	<td> <?php echo $Data_row['start_date'];?>  </td>
      	<td> <?php echo $Data_row['end_date'];?> </td>
      	<td> <?php echo $Data_row['company'];?> </td>
      	<td><?php echo $Data_row['job_title'];?> </td>
      </tr>
            <?php } //enf foreach?>
    </table>
    <?php } //end if?>
    
    </div>
    
    </div>

    </div><!-- profile-third-white-box -->

    </div>  
    <!-- profile warrper -->
    
 </div> <!-- content -->
   
        <?php include('../includes/footer.php');?>

   
</div>
  
  <!-- Wraper -->



</body>
</html>
