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
$educ_Array =$objDb->getArray($sqlEduc);
	$items = array();
	while($row = mysql_fetch_object($educ_Array)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

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


	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			color:#666;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
	</style>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var url;
		function newEducation(){
			$('#dlg').dialog('open').dialog('setTitle','New Education');
			$('#fm').form('clear');
			url = '../ajax/action.php?action=addEducation';
		}
		function editEducation(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Education');
				$('#fm').form('load',row);
				url = '../ajax/action.php?action=editEducation&id='+row.id;
			}
		}
		function saveEducation(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					alert("URL :: "+url);
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
		function removeEducation(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to remove this record?',function(r){
					if (r){
						$.post('remove_user.php',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}
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
    
    <!--<div class="profile-third-box-detail">
    
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
                <td>  <a id="edit-edu" onClick="edit("+<?php echo $Data_row['id'] ?>+")" > Edit</a>  <a  onClick="deleteRow("+<?php echo $Data_row['id'] ?>+")"> Delete</a> </td>

                <td>  <?php echo $Data_row['start_date'];?> </td>
                <td>  <?php echo $Data_row['end_date'];?> </td>
                <td>  <?php echo $Data_row['school'];?> </td> 
                <td>  <?php echo $Data_row['degree'].' '.$Data_row['subject'];?> </td>
                                                               
            </tr>
            <?php } //enf foreach?>
    </table>
    <?php } //end if?>
    
   
    </div>
</div>-->
	<table id="dg" title="My Education" class="easyui-datagrid" style="width:700px;height:250px"
			url="profile.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="degree" width="50">Degree</th>
				<th field="subject" width="50">Subject</th>
				<th field="school" width="50">School</th>

			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newEducation()">New Education</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editEducation()">Edit Education</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeEducation()">Remove Education</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Education Information</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>Degree:</label>
				<input name="degree" class="easyui-validatebox" required>
			</div>
			<div class="fitem">
				<label>Subject:</label>
				<input name="subject" class="easyui-validatebox" required>
			</div>
			<div class="fitem">
				<label>School:</label>
				<input name="school">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveEducation()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
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
