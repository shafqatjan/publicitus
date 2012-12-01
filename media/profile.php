<?php 
include('../settings/settings.php');
include('../helpers/helper.php');


$objSession = new Session(CLIENT_ROLE_MEDIA);
$objSession->checkSession(CLIENT_ROLE_MEDIA,"../index.php") ;

$objDb = new Database();
$objDb->connect();
$objCat = new Categories();
$objMediaType = new MediaType();
$objUser = new User();
$objShows = new Shows();

$objUserCategoriesMap = new UserCategoriesMap();

$sql = $objUser->PopulateGrid("*"," AND id= ".$objSession->id);  
$userInfo = $objDb->getArraySingle($sql);
//Query to get shows
$sqlShow = $objShows->PopulateGrid("*"," AND status = 1  AND user_id= ".$objSession->id); 
$shows_Array = $objDb->getArray($sqlShow);



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
	
	function deleteShow(id){
	    var id = id;
		var url	= '../ajax/action.php?action=deleteShow&id='+id;	
	    var res= confirm("Do you really want to delete this record ?");
		if(res){
				$.get(url,{language: "php", version: 5},  
					function(responseText){  
					alert(responseText);
						$("#row_"+id).hide();  
					},  
					"html"  
				);  
		}
	}
	
	
 
    jQuery(function() {
//        var degree = jQuery( "#degree" ),
  //          subject = jQuery( "#subject" ),
    //        start_month = jQuery( "#start_month" ),
		//	end_month = jQuery( "#end_month" ),
          //  start_year = jQuery( "#start_year" ),
//			end_year = jQuery( "#end_year" ),
	//		school = jQuery( "#school" ),
		//	edu_description = jQuery( "#edu_description" ),
          //  allFields = jQuery( [] ).add( degree ).add( subject ).add( start_month ).add( end_month ).add( start_year ).add( end_year ).add(school),
            //tips = jQuery( ".validateTips" );
			

		
  		
 
        jQuery( "#shows-dialog-form" ).dialog({
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
					param = "action=addShow&id="+jQuery("#showId").val()+"&show_name="+jQuery("#show_name").val()+"&show_time="+jQuery("#show_time").val()+"&show_date="+jQuery("#show_date").val()+"&show_duration="+jQuery("#show_duration").val()+"&show_cost="+jQuery("#show_cost").val()+"&media_type="+jQuery("#media_type").val()+"&show_description="+jQuery("#show_description").val();
					alert("param : "+param);
					jQuery.ajax({
							   type		: "GET",
							   data 	: param,
							   async	: false,
							   url 		: '../ajax/action.php?'+param,
							   success 	: function(response)
							   {
								   alert(response);
									if(response.substr(0,6) == "sucadd")
									   jQuery("#showTab").append(response.substr(6));
									if(response.substr(0,6) == "sucupd")
									   jQuery("#showTab #row_"+jQuery("#showId").val()).html(response.substr(6));
										jQuery( "#show_name" ).val('');
										jQuery( "#show_duration" ).val('');
										jQuery( "#show_cost" ).val('');
										jQuery( "#show_time" ).val('');
										jQuery( "#show_date" ).val('');
										jQuery( "#show_description" ).val('');
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
         jQuery( "#add-edu" )
            .button()
            .click(function() {
				jQuery( ".popup-heading" ).html("");
                jQuery( "#shows-dialog-form" ).dialog( "open" );
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

	function editShow (id){
	    var id = id;		
		//alert("ID :: "+id);
		jQuery( ".popup-heading" ).html("Edit Education");
		var url	= '../ajax/action.php?action=editShow &id='+id;	
				$.get(url,{language: "php", version: 5},  
					function(responseText){
						//alert(responseText);  
						var json = responseText;
						obj = JSON.parse(json);
						jQuery( "#job_title" ).val(obj.job_title);
						jQuery( "#company" ).val(obj.company);
						jQuery( "#st_month" ).val(obj.start_month);
						jQuery( "#e_month" ).val(obj.end_month);
						jQuery( "#st_year" ).val(obj.start_year);
//						jQuery( "#st_year" ).val(obj.end_year);
						jQuery( "#e_year" ).val(obj.end_year);
						jQuery( "#job_description" ).val(obj.job_description);
						jQuery( "#expId" ).val(id);
						jQuery( ".popup-heading" ).html("Edit Experience");
					},  
					"html"  
				);  
		
         jQuery( "#shows-dialog-form" ).dialog("open" );
	}


function selectDate(id){
	//alert(id);
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
        <div class="profile-display-name"> <h2>  <?php echo $company;?>  </h2> </div>
        <div class="profile-profession"> <h4> <?php echo $address;?>   </h4> </div>
        <div class="profile-company-address"> <p>   </p> </div>
        <div class="privious-job"> 
             <span class="privious-heading"> <p class="job-heading"> </p> </span>
             <span class="privious-job-detial"> <p class="job-detail">  </p>     </span>
        </div>
        <div class="privious-job"> 
           <span class="privious-heading"> <p class="job-heading">  </p> </span>
           <span class="privious-job-detial"> <p class="job-detail">  </p> </span>
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
     <h3 class="background-heading"> Show  </h3>
     <span class="add-info">  <span class="blue-box-endorse-btn"> <input type="button" id="add-edu" value="Add Info"> </span>  </span>
    </div>
    
    <div class="education-detail">

    <?php 
		if(count($shows_Array)>0)
		{
			//printArray($shows_Array);
	?>
     
     <table id="showTab" class="gridtable">
     
     <tr>
      <th width="150">Action</th>
      <th width="100">Show Name</th>
      <th width="150">Schedule date</th>
      <th width="200">Media</th>
     </tr>
     
		<?php 
			foreach($shows_Array as $Data_row)
			{
		?>
            <tr id="row_<?=$Data_row['id'];?>">
                <td>  <a id="edit-edu" onClick="editShow(<?php echo $Data_row['id'] ?>)" > Edit</a>  <a  onClick="deleteShow(<?php echo $Data_row['id'] ?>)"> Delete</a> </td>

                <td>  <?php echo $Data_row['show_name'];?> </td> 
                <td>  <?php echo $Data_row['show_date'].' '.$Data_row['show_time'];?> </td> 
                <td>  <?php echo $Data_row['media_type_id'];?> </td> 
                                                               
            </tr>
            <?php } //enf foreach?>
    </table>
    <?php } //end if?>
    
   
    </div>
</div>
 


<div id="shows-dialog-form"  style="display:none" class="popup-box-warpper">
  <div class="popup-box"> 
   <div class="popup-heading"> Add Show </div>
   <div class="popup-form">
      <div class="popup-form-row">
         <div class="popup-form-text"> Show Name </div>
         <div class="popup-box-input"> <input class="text ui-widget-content ui-corner-all" type="text" name="show_name" id="show_name"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Duration in Minutes </div>
         <div class="popup-box-input"> 
          <input class="text ui-widget-content ui-corner-all" type="text" name="show_duration" id="show_duration"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Cost per Minute </div>
         <div class="popup-box-input"> <input class="text ui-widget-content ui-corner-all" type="text" name="show_cost" id="show_cost"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Date </div>
         <div class="popup-box-input"> <input class="text ui-widget-content ui-corner-all" type="text" name="show_date" id="show_date"> Time <input class="text ui-widget-content ui-corner-all" type="text" name="show_time" id="show_time"> </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Media Type </div>
         <div class="popup-box-input"> 
         <select name="media_type" id="media_type" style="width:130px;"> 
            <option value="12"> December </option>             
         </select> 
         </div>
      </div>
      <div class="popup-form-row">
         <div class="popup-form-text"> Description </div>
         <div class="popup-box-input"> <textarea name="show_description" id="show_description"  style="width: 255px; height: 87px;"> </textarea> </div>
                    <input type="hidden" name="showId" id="showId"> </div>

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

 <!-- popup-box -->
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
