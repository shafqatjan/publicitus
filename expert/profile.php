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

      $t = time();
	  $current_year = date('Y',$t);
		 

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">

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
	function edit(id){
	    var id = id;		
		//window.location = ""
         jQuery( "#msgDilog" ).dialog( "open" );

        jQuery( "#msgDilog" ).dialog({
            autoOpen: false,
            height: 200,
            width: 200,
            modal: true,
            buttons: {
                "DELETE": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" ); 
					//var roleCatId=jQuery("#roleCatId").val();
					param =  "action=delete&id="+id;
					alert("param :: "+'ajax/action.php?'+param);
					//jQuery('#roleSubCatDropDiv').html('');	
					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: '../ajax/action.php?'+param,
							   success 	: function(msg)
							   {
									alert("Response msg :: "+msg);
									//document.reload();
									document.location.reload(true);
								//jQuery('#roleSubCatDropDiv').html(msg);
							   }
						});
                        jQuery( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    jQuery( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });

	}

 


	function deleteRow(id){
	    var id = id;		
	    alert(" ID :: "+id)	;
		window.location = ""
	}

    jQuery(function() {
        var degree = jQuery( "#degree" ),
            subject = jQuery( "#subject" ),
            start_month = jQuery( "#start_month" ),
			end_month = jQuery( "#end_month" ),
            start_year = jQuery( "#start_year" ),
			end_year = jQuery( "#end_year" ),
			school = jQuery( "#school" ),
			edu_description = jQuery( "#edu_description" ),
            allFields = jQuery( [] ).add( degree ).add( subject ).add( start_month ).add( end_month ).add( start_year ).add( end_year ).add(school),
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
            height: 575,
            width: 575.6,
            modal: true,
            buttons: {
                "Add": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" ); 
                    bValid = bValid && checkLength( degree, "degree", 2, 16 );
                    bValid = bValid && checkLength( subject, "subject", 2, 80 );
                    bValid = bValid && checkLength( school, "school", 3, 80 );
                    if ( bValid ) {
					//var roleCatId=jQuery("#roleCatId").val();
					//param =  "action=add";
					param = "action=add&degree="+jQuery("#degree").val()+"&subject="+jQuery("#subject").val()+"&school="+jQuery("#school").val()+"&start_month="+jQuery("#start_month").val()+"&end_month="+jQuery("#end_month").val()+"&start_year="+jQuery("#start_year").val()+"&end_year="+jQuery("#end_year").val()+"&edu_description="+jQuery("#edu_description").val();
					//alert("val "+val);
					alert("param :: "+'ajax/action.php?'+param);
					//jQuery('#roleSubCatDropDiv').html('');	
					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: '../ajax/action.php?'+param,
							   success 	: function(msg)
							   {
									alert("Response msg :: "+msg);
									//document.reload();
									document.location.reload(true);
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


        jQuery( "#edu-edit-dialog-form" ).dialog({
            autoOpen: false,
            height: 575,
            width: 575.6,
            modal: true,
            buttons: {
                "Add": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" ); 
                    bValid = bValid && checkLength( degree, "degree", 2, 16 );
                    bValid = bValid && checkLength( subject, "subject", 2, 80 );
                    bValid = bValid && checkLength( school, "school", 3, 16 );
                    if ( bValid ) {
					//var roleCatId=jQuery("#roleCatId").val();
					param =  "action=edit&id";
					href="action=edit&id=<?php echo $Data_row['id'];?>"
					alert("param :: "+'ajax/action.php?'+param);
					//jQuery('#roleSubCatDropDiv').html('');	
					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: 'ajax/action.php?'+param,
							   success 	: function(msg)
							   {
									alert("url :: "+url);
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
            height: 575,
            width: 575.6,
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
     <span class="add-info">  <span class="blue-box-endorse-btn"> <input type="button" id="add-edu" value="Add Info"> </span>  </span>
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
                <td>  <a id="edit-edu" onClick="edit(<?php echo $Data_row['id'] ?>)" > Edit</a>  <a  onClick="deleteRow(<?php echo $Data_row['id'] ?>)"> Delete</a> </td>

                <td>  <?php if($Data_row['start_year']==00){echo "present";} else echo $Data_row['start_year'];?> </td>
                <td>  <?php if($Data_row['end_year']==00){echo "present";} else echo $Data_row['end_year'];?>  </td>
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
         <span class="add-info">  <span class="blue-box-endorse-btn"> <input type="button" id="add-exper" value="Add Info"> </span>  </span>
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
      	<td> <a href="" > Edit </a><p> <a href="action=edit&id=<?php echo $Data_row['id'];?>" > Delete</a></p> </td>
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


<div id="edu-dialog-form"  style="display:none" class="popup-box-warpper">
  <div class="popup-box"> 
   <div class="popup-heading"> Add Education </div>
   
   <div class="popup-form">
   
      <div class="popup-form-row">
         <div class="popup-form-text"> School Name </div>
         <div class="popup-box-input"> <input type="text" name="school" id="school"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Degree </div>
         <div class="popup-box-input"> <select name="degree" id="degree"> <option value="Masters" > Masters </option> </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Area Of Study </div>
         <div class="popup-box-input"> <input type="text" name="subject" id="subject"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> From </div>
         <div class="popup-box-input"> 
         <select name="start_month" id="start_month" style="width:130px;">
            <option value="0"> Present </option> 
            <option value="1"> January </option> 
            <option value="2"> February </option>             
            <option value="3"> March </option>             
            <option value="4"> April </option>             
            <option value="5"> May </option>             
            <option value="6"> June </option>             
            <option value="7"> July </option>             
            <option value="8"> August </option>             
            <option value="9"> September </option>             
            <option value="10"> October </option>             
            <option value="11"> November </option>             
            <option value="12"> December </option>             
         </select> 
         <select name="start_year" id="start_year" style="width:90px;">
            <option value="00"> Present </option>          
           <?php for ($y = $current_year; $y>=1995  ; $y-- ){?> 
            <option value="<?php echo $y; ?> ">  <?php echo $y; ?> </option> 
           <?php }?>
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> To </div>
         <div class="popup-box-input"> 
         <select name="end_month" id="end_month" style="width:130px;"> 
            <option value="0"> Present </option> 
            <option value="1"> January </option> 
            <option value="2"> February </option>             
            <option value="3"> March </option>             
            <option value="4"> April </option>             
            <option value="5"> May </option>             
            <option value="6"> June </option>             
            <option value="7"> July </option>             
            <option value="8"> August </option>             
            <option value="9"> September </option>             
            <option value="10"> October </option>             
            <option value="11"> November </option>             
            <option value="12"> December </option>             
         </select> 
         <select name="end_year" id="end_year" style="width:90px;"> 
            <option value="00"> Present </option>                   
           <?php for ($y = $current_year; $y>=1995  ; $y-- ){?> 
            <option value="<?php echo $y; ?>" >  <?php echo $y; ?> </option> 
           <?php }?>
          
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Description </div>
         <div class="popup-box-input"> <textarea name="edu_description" id="edu_description"> </textarea> </div>
      </div>
      
      <div class="popup-form-row">
      
      <div class="popup-form-text"> &nbsp; </div>
   <!--     <div class="popup-box-input">
         <input type="button" value="Save">
         <input type="button" value="Save and Add More">
         <input type="button" value="Cancle">
        </div>
       -->  
      </div>
      
   </div>  
  </div> <!-- popup-box -->
  </div> <!-- popup-box-warpper -->
  <div id="msgDilog" style="display:none"> Do u want to delete this ?
  </div>
  <!-- edid education dialog -->
  <div id="edu-edit-dialog-form"  style="display:none" class="popup-box-warpper">
  <div class="popup-box"> 
   <div class="popup-heading"> Add Employment </div>
   
   <div class="popup-form">
   
      <div class="popup-form-row">
         <div class="popup-form-text"> School Name </div>
         <div class="popup-box-input"> <input type="text" name="school" id="school"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Degree </div>
         <div class="popup-box-input"> <select name="degree" id="degree"> <option> Master </option> </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Area Of Study </div>
         <div class="popup-box-input"> <input type="text" name="subject" id="subject"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> From </div>
         <div class="popup-box-input"> 
         <select name="start_month" id="st_month" style="width:130px;">
            <option value="0"> Present </option> 
            <option value="1"> January </option> 
            <option value="2"> February </option>             
            <option value="3"> March </option>             
            <option value="4"> April </option>             
            <option value="5"> May </option>             
            <option value="6"> June </option>             
            <option value="7"> July </option>             
            <option value="8"> August </option>             
            <option value="9"> September </option>             
            <option value="10"> October </option>             
            <option value="11"> November </option>             
            <option value="12"> December </option>             
         </select> 
         <select name="start_year" id="st_year" style="width:90px;">
            <option value="00"> Present </option>          
           <?php for ($y = $current_year; $y>=1995  ; $y-- ){?> 
            <option value="<?php echo $y; ?> ">  <?php echo $y; ?> </option> 
           <?php }?>
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> To </div>
         <div class="popup-box-input"> 
         <select name="end_month" id="e_month" style="width:130px;"> 
            <option value="0"> Present </option> 
            <option value="1"> January </option> 
            <option value="2"> February </option>             
            <option value="3"> March </option>             
            <option value="4"> April </option>             
            <option value="5"> May </option>             
            <option value="6"> June </option>             
            <option value="7"> July </option>             
            <option value="8"> August </option>             
            <option value="9"> September </option>             
            <option value="10"> October </option>             
            <option value="11"> November </option>             
            <option value="12"> December </option>             
         </select> 
         <select name="end_year" id="e_year" style="width:90px;"> 
            <option value="00"> Present </option>                   
           <?php for ($y = $current_year; $y>=1995  ; $y-- ){?> 
            <option value="<?php echo $y; ?>" >  <?php echo $y; ?> </option> 
           <?php }?>
          
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Description </div>
         <div class="popup-box-input"> <textarea name="edu_description" id="edu_description"> </textarea> </div>
      </div>_
      
      <div class="popup-form-row">
      
      <div class="popup-form-text"> &nbsp; </div>
   <!--     <div class="popup-box-input">
         <input type="button" value="Save">
         <input type="button" value="Save and Add More">
         <input type="button" value="Cancle">
        </div>
       -->  
      </div>
      
   </div>  
  </div> <!-- popup-box -->
  </div> <!-- popup-box-warpper -->

<div id="exper-dialog-form"  style="display:none" class="popup-box-warpper">
  <div class="popup-box"> 
   <div class="popup-heading"> Add Employment </div>
   
   <div class="popup-form">
   
      <div class="popup-form-row">
         <div class="popup-form-text"> Company Name </div>
         <div class="popup-box-input"> <input type="text"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Role </div>
         <div class="popup-box-input"> <select> <option> Independent Contributor </option> </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> From </div>
         <div class="popup-box-input"> 
         <select name="start_month" id="st_month" style="width:130px;">
            <option value="0"> Present </option> 
            <option value="1"> January </option> 
            <option value="2"> February </option>             
            <option value="3"> March </option>             
            <option value="4"> April </option>             
            <option value="5"> May </option>             
            <option value="6"> June </option>             
            <option value="7"> July </option>             
            <option value="8"> August </option>             
            <option value="9"> September </option>             
            <option value="10"> October </option>             
            <option value="11"> November </option>             
            <option value="12"> December </option>             
         </select> 
         <select name="start_year" id="st_year" style="width:90px;">
            <option value="00"> Present </option>          
           <?php for ($y = $current_year; $y>=1995  ; $y-- ){?> 
            <option value="<?php echo $y; ?> ">  <?php echo $y; ?> </option> 
           <?php }?>
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> To </div>
         <div class="popup-box-input"> 
         <select name="end_month" id="e_month" style="width:130px;"> 
            <option value="0"> Present </option> 
            <option value="1"> January </option> 
            <option value="2"> February </option>             
            <option value="3"> March </option>             
            <option value="4"> April </option>             
            <option value="5"> May </option>             
            <option value="6"> June </option>             
            <option value="7"> July </option>             
            <option value="8"> August </option>             
            <option value="9"> September </option>             
            <option value="10"> October </option>             
            <option value="11"> November </option>             
            <option value="12"> December </option>             
         </select> 
         <select name="end_year" id="e_year" style="width:90px;"> 
            <option value="00"> Present </option>                   
           <?php for ($y = $current_year; $y>=1995  ; $y-- ){?> 
            <option value="<?php echo $y; ?>" >  <?php echo $y; ?> </option> 
           <?php }?>
          
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Description </div>
         <div class="popup-box-input"> <textarea> </textarea> </div>
      </div>
      
      <div class="popup-form-row">
      
      <div class="popup-form-text"> &nbsp; </div>
   <!--     <div class="popup-box-input">
         <input type="button" value="Save">
         <input type="button" value="Save and Add More">
         <input type="button" value="Cancle">
        </div>
       -->  
      </div>
      
   </div>  
  </div> <!-- popup-box -->
  </div> <!-- popup-box-warpper -->  
    </div><!-- profile-third-white-box -->

    </div>  
    <!-- profile warrper -->
        <?php include('../includes/footer.php');?>

 </div> <!-- content -->

   
</div>
  
  <!-- Wraper -->



</body>
</html>
