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
						jQuery( ".popup-heading" ).html("Edit Education");

		var url	= '../ajax/action.php?action=editExperience&id='+id;	
				$.get(url,{language: "php", version: 5},  
					function(responseText){  
						var json = responseText;
						obj = JSON.parse(json);
						//alert(obj.degree+' '+obj.subject+' '+obj.start_month);
						jQuery( "#degree" ).val(obj.degree);
						jQuery("#subject").add(obj.subject);
						jQuery( "#start_month" ).val(obj.start_month);
						jQuery( "#end_month" ).val(obj.end_month);
						jQuery( "#start_year" ).val(obj.start_year);
						jQuery( "#end_year" ).val(obj.end_year);
						jQuery( "#school" ).val(obj.school);
						jQuery( "#edu_description" ).val(obj.edu_description);
						jQuery( "#eduId" ).val(id);
						
						
					},  
					"html"  
				);  
		
         jQuery( "#edu-dialog-form" ).dialog("open" );

	}

	function editExperience(id){
	    var id = id;		
		//window.location = ""
		var url	= '../ajax/action.php?action=edit&id='+id;	
				$.get(url,{language: "php", version: 5},  
					function(responseText){  
						var json = responseText;
						obj = JSON.parse(json);
						alert(obj.degree+' '+obj.subject+' '+obj.start_month);
						jQuery( "#job_title" ).val(obj.job_title);
						jQuery( "#company" ).add(obj.company);
						jQuery( "#st_month" ).val(obj.start_month);
						jQuery( "#e_month" ).val(obj.end_month);
						jQuery( "#st_year" ).val(obj.start_year);
						jQuery( "#e_year" ).val(obj.end_year);
						jQuery( "#school" ).val(obj.school);
						jQuery( "#job_description" ).val(obj.job_description);
						jQuery( "#expId" ).val(id);
						jQuery( ".popup-heading" ).html("Edit Experience");
						
						
					},  
					"html"  
				);  
		
         jQuery( "#edu-dialog-form" ).dialog("open" );

	}
	
	function deleteRow(id){
	    var id = id;
		var url	= '../ajax/action.php?action=delete&id='+id;	
	    var res= confirm("Do you really want to delete this record ?");
		if(res){
				$.get(url,{language: "php", version: 5},  
					function(responseText){  
					//alert(responseText);
						$("#row_"+id).hide();  
					},  
					"html"  
				);  
		}
		
	}
	function deleteExperience(id){
	    var id = id;
		var url	= '../ajax/action.php?action=deleteExperience&id='+id;	
	    var res= confirm("Do you really want to delete this record ?");
		if(res){
				$.get(url,{language: "php", version: 5},  
					function(responseText){  
					//alert(responseText);
						$("#row_"+id).hide();  
					},  
					"html"  
				);  
		}
		
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
                "Save": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" ); 
                    //bValid = bValid && checkLength( degree, "degree", 2, 20 );
                    //bValid = bValid && checkLength( subject, "subject", 2, 80 );
                    //bValid = bValid && checkLength( school, "school", 3, 100 );
                    if ( bValid ) {
					param = "action=add&id="+jQuery("#eduId").val()+"&degree="+jQuery("#degree").val()+"&subject="+jQuery("#subject").val()+"&school="+jQuery("#school").val()+"&start_month="+jQuery("#start_month").val()+"&end_month="+jQuery("#end_month").val()+"&start_year="+jQuery("#start_year").val()+"&end_year="+jQuery("#end_year").val()+"&edu_description="+jQuery("#edu_description").val();
					alert("param : "+param);

					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: '../ajax/action.php?'+param,
							   success 	: function(response)
							   {
									if(response.substr(0,6) == "sucadd")
									   jQuery("#eduTab").append(response.substr(6));
									if(response.substr(0,6) == "sucupd")
									   jQuery("#eduTab #row_"+jQuery("#eduId").val()).html(response.substr(6));
									   
										jQuery( "#degree" ).val('');
										jQuery( "#subject" ).val('');
										jQuery( "#start_month" ).val('');
										jQuery( "#end_month" ).val('');
										jQuery( "#start_year" ).val('');
										jQuery( "#end_year" ).val('');
										jQuery( "#school" ).val('');
										jQuery( "#edu_description" ).val('');									   
									   
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
                "Save": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" ); 
                   // bValid = bValid && checkLength( degree, "degree", 2, 16 );
                    //bValid = bValid && checkLength( subject, "subject", 2, 80 );
                    //bValid = bValid && checkLength( school, "school", 3, 80 );
                    if ( bValid ) {
					//var roleCatId=jQuery("#roleCatId").val();
					//param =  "action=add";
					param = "action=addExperience&id"+jQuery("#expId").val()+"=&job_title="+jQuery("#job_title").val()+"&company="+jQuery("#company").val()+"&start_month="+jQuery("#st_month").val()+"&end_month="+jQuery("#e_month").val()+"&start_year="+jQuery("#st_year").val()+"&e_year="+jQuery("#e_year").val()+"&job_description="+jQuery("#job_description").val();
					//alert("val "+val);
					alert("param :: "+'ajax/action.php?'+param);
					//jQuery('#roleSubCatDropDiv').html('');	
					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: '../ajax/action.php?'+param,
							   success 	: function(response)
							   {
								   alert(response);
									if(response.substr(0,6) == "sucadd")
									   jQuery("#expTab").append(response.substr(6));
									if(response.substr(0,6) == "sucupd")
									   jQuery("#expTab #row_"+jQuery("#expId").val()).html(response.substr(6));
									   
										jQuery( "#job_title" ).val('');
										jQuery( "#company" ).val('');
										jQuery( "#st_month" ).val('');
										jQuery( "#e_month" ).val('');
										jQuery( "#st_year" ).val('');
										jQuery( "#e_year" ).val('');
										jQuery( "#school" ).val('');
										jQuery( "#job_description" ).val('');									   
									   
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
 
// end add experience
        jQuery( "#add-exper" )
            .button()
            .click(function() {
				jQuery( ".popup-heading" ).html("Add Experience");
                jQuery( "#exper-dialog-form" ).dialog( "open" );
            });
        jQuery( "#add-edu" )
            .button()
            .click(function() {
				jQuery( ".popup-heading" ).html("Add Education");
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
     
     <table id="eduTab" class="gridtable">
     
     <tr>
      <th width="100">Action</th>
      <th width="50">From</th>
      <th width="50">To</th>
      <th width="200">School</th>
      <th width="200">Degree</th>
     </tr>
     
		<?php 
			foreach($educ_Array as $Data_row)
			{
		?>
            <tr id="row_<?=$Data_row['id'];?>">
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
     
       <table id="expTab" class="gridtable">
     
     <tr>
      <th width="100">Action</th>
      <th width="50">From</th>
      <th width="50">To</th>
      <th width="200">Company</th>
      <th width="200">Time/role</th>
     </tr>     
		<?php 
			foreach($exp_Array as $Data_row)
			{
		?>
     
            <tr id="row_<?=$Data_row['id'];?>">
                <td>  <a id="edit-edu" onClick="editExperience(<?php echo $Data_row['id'] ?>)" > Edit</a>  <a  onClick="deleteExperience(<?php echo $Data_row['id'] ?>)"> Delete</a> </td>
        <td>  <?php if($Data_row['st_year']==00){echo "present";} else echo $Data_row['st_year'];?> </td>
        <td>  <?php if($Data_row['e_year']==00){echo "present";} else echo $Data_row['e_year'];?>  </td>
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
         <div class="popup-box-input"> <input class="text ui-widget-content ui-corner-all" type="text" name="school" id="school"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Degree </div>
         <div class="popup-box-input"> 
         <select name="degree" id="degree"> 
             <option value="Masters" > Masters </option> 
             <option value="Bachlor" > Bachlor </option> 
         </select> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Area Of Study </div>
         <div class="popup-box-input"> <input class="text ui-widget-content ui-corner-all" type="text" name="subject" id="abcd"> </div>
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
                    <input type="hidden" name="id" id="eduId"> </div>

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
  <!----> <!-- popup-box-warpper -->

<div id="exper-dialog-form"  style="display:none" class="popup-box-warpper">
  <div class="popup-box"> 
   <div class="popup-heading"> Add Employment </div>
   
   <div class="popup-form">
   
      <div class="popup-form-row">
         <div class="popup-form-text"> Job Title </div>
         <div class="popup-box-input"> <input type="text" id="job_title" name="job_title"> </div>
      </div>

      <div class="popup-form-row">
         <div class="popup-form-text"> Company Name </div>
         <div class="popup-box-input"> <input type="text" id="company" name="company"> </div>
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
         <div class="popup-form-text"> Job Description </div>
         <div class="popup-box-input"> <textarea id="job_description" name="job_description"> </textarea> </div>
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
