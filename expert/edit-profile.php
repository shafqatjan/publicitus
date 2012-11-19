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
$objUserMediaMap = new UserMediaMap();


//get user info to edit
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
$rate 				    = $userInfo['rate'];
$mediaType 				= $userInfo['mediaType'];


$sqlUserCat = $objUserCategoriesMap->PopulateGrid("category_id"," AND status = 1 AND user_id= ".$objSession->id);  
$ucategories = $objDb->getArray($sqlUserCat);
$categories = array();
foreach($ucategories as $ucat)
array_push($categories, $ucat['category_id']);

$sqlUserMedia = $objUserMediaMap->PopulateGrid("media_id"," AND status = 1 AND user_id= ".$objSession->id);  
$umedia = $objDb->getArray($sqlUserMedia);
$mediaArr = array();
foreach($umedia as $umedi)
array_push($mediaArr, $umedi['media_id']);

//printArray($mediaArr); exit;




$error = '';

$sqlAllCat = $objCat->PopulateGrid("*",' AND status = 1 ')." order by title";  
$cat_Array = $objDb->getArray($sqlAllCat);


if(isset($_POST['btn_save']))
{
//printArray($_POST); exit;

    $firstName 				= isset($_POST['firstName'])?$_POST['firstName']:'';
    $lastName 				= isset($_POST['lastName'])?$_POST['lastName']:'';
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
	$catCount 				= isset($_POST['catCount'])?$_POST['catCount']:'';
	$rate                   = isset($_POST['rate'])?$_POST['rate']:'';

//printArray($_POST);exit;

	$objUser->id = $objSession->id;
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
	$objUser->rate = $rate;
	$objUser->mediaType = $mediaType;
	
	$categories = array();
    $error .= $objUser->validateUpdate();
    if($objUser->mediaType == 0)
 	   $error .= '&nbsp;&bull;&nbsp;Please select media type.<br>';

	for($i = 1; $i<= $catCount; $i++)
	  if(!empty($_POST['cat_'.$i]))
		  array_push($categories, $_POST['cat_'.$i]);

	if(count($categories)==0)		
			$error .= '&nbsp;&bull;&nbsp;Select categoties.<br>';
			//printArray($categories);exit;
	if(empty($error))
		{
			if($objDb->execute($objUser->Update()))
			{
				$latestId = $objSession->id;
				//delete previous user categories
				$objDb->execute($objUserCategoriesMap->DeleteByUserId()); 
				//add cat and media 
				$valuesClause = 'Values';
                $count = count($categories);
				for($j = 0 ; $j<$count; $j++)
				{
					$valuesClause .='('. $latestId .' , '.$categories[$j].'),';
				}
				$valuesClause = trim($valuesClause,",");
				//echo $valuesClause; exit;
				$objDb->execute($objUserCategoriesMap->AddUserCat($valuesClause));
				// add media 
				$objUserMediaMap->user_id = $latestId;
				$objUserMediaMap->media_id = $mediaType;
				$objDb->execute($objUserMediaMap->UpdateUserMediaMap());

				
				$objSession->setSessMsg('Profile updated successfully.');							
				$objSession->redirectTo(SITE_ROOT.'/expert/profile.php');
			
				//exit;
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
    <form method="post" action="">
      <div id="form-warrper">
      <?php include("../includes/err-succ-info.php");  ?>
	 
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


        <div class="two-col">
          <div class="col-one">
            <label> Rate ($/minute)</label>
          </div>
          <div class="col-two">
      <input type=text name="rate" id="rate" value="<?php echo $rate; ?>">
          </div>
          <div class="error"></div>
        </div>

        <div class="two-col">
          <div class="col-one">
            <label> Media Type <span style="color:red">*</span></label>
          </div>
          <div class="col-two">
            <select name="mediaType" id="mediaType">
              <option value="0"> Select Type Of Media... </option>
              <?php 
				if(count($Data_Array)>0)
				{
					foreach($Data_Array as $Data_row)
					{
						//echo $Data_row['id'] .' = '.$mediaArr['media_id'];
				         if(in_array($Data_row['id'],$mediaArr))

							echo "<option value=". $Data_row['id']." selected='selected'>". $Data_row['title']."</option>";
						 else
							echo "<option value=". $Data_row['id'].">". $Data_row['title']."</option>";						
					}
				}
				
				?>
            </select>
          </div>
          <div class="error"></div>
        </div>
    <div class="form-head">  
    	<h3> Categories </h3>
    </div>
    
    <!--  Looop    echo '<pre>';print_r($_POST); -->
        <div class="three-col">





    <?php 

// Retrieve Categories 

	if(count($cat_Array)>0)
	{ ?>   
    <div class="form-head">  
    	<h3> Experties </h3>
    </div>
    
    <!--  Looop    echo '<pre>';print_r($_POST); -->
        <div class="three-col">
        <?php
		$co = 0;
		foreach($cat_Array as $Data_row)
		{

			$co++;
			
	?>
          <div class="three-col-col">
            <?php if(in_array($Data_row['id'],$categories)){ ?>
            <input type="checkbox" value="<?php echo $Data_row['id']?>" name="cat_<?php echo $co;?>" id="cat_<?php echo $co;?>" checked="checked">
            <?php } else { 
			?>
           <input type="checkbox" value="<?php echo $Data_row['id']?>" name="cat_<?php echo $co;?>" id="cat_<?php echo $co;?>"> 
            <?php	
			}?>
            <label> <?php echo $Data_row['title'] ?> </label>
          </div>
          <?php
		}
		?>  </div><?php
	}
	?>
    
    
    <!--  End Looop   -->
        
 <input type="hidden" id="catCount" name="catCount" value="<?php echo $co;?>">
    
    <div class="submit-btn">
    <input type="submit" id="btn_save"  name="btn_save" value="Update">
              <input type="button" value="Cancel" onclick="window.location='<?php echo SITE_ROOT.'expert/';?>'">
    </div>
    
   </div> <!-- 3 colum -->
  </form>
  </div><!-- form wrapper -->
  </div> <!-- content -->
  
  <!-- footer -->
    <?php include('../includes/footer.php');?>
 
 </div> <!-- Warpper -->

</body>
</html>
