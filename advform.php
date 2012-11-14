<?php 
include('settings/settings.php');
include('helpers/helper.php');




$objSession = new Session();
 
$objDb = new Database();
$objDb->connect();

$objCat = new Categories();
$objMediaType = new MediaType();
$objUser = new User();
$objUserCategoriesMap = new UserCategoriesMap();
$objUserMediaMap = new UserMediaMap();

$firstName 				= '';
$lastName 				= '';
$email 					= '';
$password 				= '';
$cpassword 		= '';
$company 				= '';
$website 				= '';
$address 				= '';
$phone 					= '';
$cell 					= '';
$city 					= '';
$state 					= '';
$zipCode 				= '';
$country 				= '';
$mediaType 				= '';
$userType				= '';
$catCount 				= '';
$category               = '';
$error = '';

$sql = $objCat->PopulateGrid("*",'')." order by title";  
$cat_Array = $objDb->getArray($sql);
$categories = array();


if(isset($_POST['btn_save']))
{
//printArray($_POST); exit;

    $firstName 				= isset($_POST['firstName'])?$_POST['firstName']:'';
    $lastName 				= isset($_POST['lastName'])?$_POST['lastName']:'';
    $email 					= isset($_POST['email'])?$_POST['email']:'';
    $password 				= isset($_POST['password'])?$_POST['password']:'';
    $cpassword 		= isset($_POST['cpassword'])?$_POST['cpassword']:'';
    $company 				= isset($_POST['company'])?$_POST['company']:'';
    $website 				= isset($_POST['website'])?$_POST['website']:'';
    $address 				= isset($_POST['address'])?$_POST['address']:'';
    $phone 					= isset($_POST['phone'])?$_POST['phone']:'';
    $cell 					= isset($_POST['cell'])?$_POST['cell']:'';
    $city 					= isset($_POST['city'])?$_POST['city']:'';
    $state 					= isset($_POST['state'])?$_POST['state']:'';
	$zipCode 				= isset($_POST['zipCode'])?$_POST['zipCode']:'';
	$country 				= isset($_POST['country'])?$_POST['country']:'';
	$mediaType 				= isset($_POST['mediaType'])?$_POST['mediaType']:'';
	$userType				= ADVERTISER;
	$catCount 				= isset($_POST['catCount'])?$_POST['catCount']:'';
	$category 				= isset($_POST['category'])?$_POST['category']:'';

	$objUser->first_name = $firstName;
	$objUser->last_name = $lastName;
	$objUser->email = $email;
	$objUser->password = $password;
	$objUser->cpassword = $cpassword;
	$objUser->company = $company;
	$objUser->website = $website;
	$objUser->address = $address;
	$objUser->phone = $phone;
	$objUser->cell = $cell;
	$objUser->city = $city;
	$objUser->state = $state;
	$objUser->zipcode = $zipCode;
	$objUser->country = $country;
	$objUser->user_type = $userType;
	$objUser->category = $category;
	
	$categories = array();

    $error .= $objUser->validate();

	for($i = 1; $i<= $catCount; $i++)
	  if(!empty($_POST['cat_'.$i]))
		  array_push($categories, $_POST['cat_'.$i]);
		
		if($mediaType==0 || $mediaType =='')		
			$error .= '&nbsp;&bull;&nbsp;Please Select media type.<br>';
		if(count($categories)==0)		
			$error .= '&nbsp;&bull;&nbsp;Please Select categoties.<br>';
		
	if(empty($error))
	{
  	   $objCategory = new Categories();	
	   if($objDb->GetCountSql($objUser->table,"AND email='".$email."'")>0)
			$error .= '&nbsp;&bull;&nbsp;Email already exists.<br>';
	   if($objDb->GetCountSql($objCategory->table,"AND title ='".$category."'")>0)	
			$error .= '&nbsp;&bull;&nbsp;Category already exists.<br>';
		if(empty($error))
		{
			if($objDb->execute($objUser->Add()))
			{
				if($objUser->category !=''){
				   $objCategory->title = $objUser->category;
				   $objCategory->status = 1;
				   $objDb->execute($objCategory->Add());
				   $query = $objCategory->PopulateGrid("id ", " AND title = '".$objCategory->title."'");
				   if($objDb->query($query) and $objDb->get_num_rows()>0)
				   {
					   	while($Temp_Row = $objDb->fetch_row_assoc())
						{
							array_push($categories,$Temp_Row['id']);
						}
				   }
				}

				$latestId = $objDb->insert_id();
				//add cat and media 
				$valuesClause = 'Values';
                $count = count($categories);
				for($j = 0 ; $j<$count; $j++)
				{
					$valuesClause .='('. $latestId .' , '.$categories[$j].'),';
				}
				$valuesClause = trim($valuesClause,",");
				$objDb->execute($objUserCategoriesMap->AddUserCat($valuesClause));
				//exit;
				$vCode = md5(date('shymi').$email);
			
				$objUser->id = $latestId;
				$objUser->email = $email;
				$objUser->verification_code = $vCode;
				$doEmail=0;
				if($objDb->execute($objUser->UpdateVarificationCode()))
					$doEmail = 1;
				if($doEmail)
				{
					$objEmail = new cMail();
					$objEmail->To = $email;
					$objEmail->RepName = 'Publicitus';
					$objEmail->Subject = 'Registration Email';
					$objEmail->From = EMAIL_NO_REPLY;
					
					$objEmail->BodyMsg  = '<br />Registration has been done successfully please click the link bilow for confirmation of your account.';
					$objEmail->Content  = '<strong>Confirm</strong> <br /><br />';
					$objEmail->Content .= '<br /><a href="'.SITE_ROOT.'varify.php?token='.$vCode.'">Confirm</a>';

					
					$objEmail->SendEmail();
					$objSession->setSessMsg('Registration successfully completed, Please chek your email to confirm.');							
					$objSession->redirectTo(SITE_ROOT.'varify.php');
				}
			}
		}
	}	
}


// Retrieve Media Types
$sqlMedia = $objMediaType->PopulateGrid("*",$qry);  
$sqlMedia .= " order by title";
$Data_Array = array();

if($objDb->query($sqlMedia) and $objDb->get_num_rows()>0)
{
	while($Temp_Row = $objDb->fetch_row_assoc())
	{
		array_push($Data_Array,$Temp_Row);
	}
}
//printArray($Data_Array);exit;

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title>Publicitus</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/modernizr.js"></script>
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
  <?php include('includes/header.php');?>
  <div id="content">
    <form method="post" action="">
          <input type="hidden" name="userType" id="userType" value="3">
      <div id="form-warrper">
      <?php include("includes/err-succ-info.php");  ?>
	 
        <div class="form-head">
          <h3> Basic Information </h3>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> First Name <span style="color:red">*</span></label>
          </div>
          <div class="col-two">
            <input type="text" name="firstName" id="firstName" value="<?php echo $firstName; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Last Name </label>
          </div>
          <div class="col-two">
            <input type="text" name="lastName" id="lastName" value="<?php echo $lastName; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Email <span style="color:red">*</span></label>
          </div>
          <div class="col-two">
            <input type="text" name="email" id="email" value="<?php echo $email; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Password <span style="color:red">*</span></label>
          </div>
          <div class="col-two">
            <input type="password" name="password" id="password" value="<?php echo $password; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Confrim Password <span style="color:red">*</span></label>
          </div>
          <div class="col-two">
            <input type="password" name="cpassword" id="cpassword" value="<?php echo $cpassword; ?>" >
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Company </label>
          </div>
          <div class="col-two">
            <input type="text" name="company" id="company" value="<?php echo $company; ?>" >
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Website </label>
          </div>
          <div class="col-two">
            <input type="text" name="website" id="website" value="<?php echo $website; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Address </label>
          </div>
          <div class="col-two">
            <textarea name="address" id="address"><?php echo $address; ?></textarea>
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Phone </label>
          </div>
          <div class="col-two">
      <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Cell <span style="color:red">*</span></label>
          </div>
          <div class="col-two">
      <input type="text" name="cell" id="cell" value="<?php echo $cell; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> City </label>
          </div>
          <div class="col-two">
      <input type="text" name="city" id="city" value="<?php echo $city; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> State </label>
          </div>
          <div class="col-two">
      <input type="text" name="state" id="state" value="<?php echo $state; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Zip Code </label>
          </div>
          <div class="col-two">
      <input type="text" name="zipCode" id="zipCode" value="<?php echo $zipCode; ?>">
          </div>
          <div class="error"></div>
        </div>
        <div class="two-col">
          <div class="col-one">
            <label> Country </label>
          </div>
          <div class="col-two">
      <input type=text name="country" id="country" value="<?php echo $country; ?>">
          </div>
          <div class="error"></div>
        </div>
    
    <div class="form-head">  
    	<h3> Advertise On </h3>
    </div>
    
    <div class="two-col">
     <div class="col-one"> <label> Media Type <span style="color:red">*</span></label> </div>     
     <div class="col-two"> 
     	<select name="mediaType" id="mediaType">
              <option value="0"> Select Type Of Media... </option>
              <?php 
				if(count($Data_Array)>0)
				{
					$co = 0;
					foreach($Data_Array as $Data_row)
					{
						if($mediaType==$Data_row['id'])
							echo "<option value=". $Data_row['id']." selected='selected'>". $Data_row['title']."</option>";
						else
							echo "<option value=". $Data_row['id'].">". $Data_row['title']."</option>";						
					}
				}
				
				?>
            </select> </div>
     <div class="error"></div>
    </div>
    
    <div class="form-head">  
    	<h3> Experties </h3>
    </div>
    
    <!--  Looop    echo '<pre>';print_r($_POST); -->
        <div class="three-col">


    <?php 

// Retrieve Categories 

	if(count($cat_Array)>0)
	{
		$co = 0;
		foreach($cat_Array as $Data_row)
		{
			$co++;
	?>
          <div class="three-col-col">
            <input type="checkbox" value="<?php echo $Data_row['id']?>" name="cat_<?php echo $co;?>" id="cat_<?php echo $co;?>" 
            <?php if(in_array($Data_row['id'],$categories)){echo 'checked';}?>>
            <label> <?php echo $Data_row['title']?> </label>
          </div>
          <?php
		}
		
	}
	?>
    <input type="hidden" id="catCount" name="catCount" value="<?php echo $co;?>">
    </div>  
    <!--  End Looop   -->
        <div class="two-col">
          <div class="col-one">
            <label> Other  </label>
          </div>
          <div class="col-two">
      <input type=text name="category" id="category">
          </div>
          <div class="error"></div>
        </div>
        
     
    
    <div class="submit-btn">
    <input type="submit" id="btn_save"  name="btn_save" value="Sign Up">
    </div>
    
   </div> <!-- form warrper -->
  </form>
  </div> <!-- content -->

  <!-- footer -->
    <?php include('includes/footer.php');?>
   
 </div> <!-- Warpper -->

</body>
</html>
