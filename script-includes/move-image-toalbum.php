<?php
include('../settings/settings.php');
require('../helpers/helper.php');

	$objSession = new Session(CLIENT_ROLE);
	$objSession->checkSession(CLIENT_ROLE,'index.php');

	$objDb = new Database();
	$objDb->connect();
	$objUserAlbums = new UserAlbums();

////////////////////GET FROM URL////////////////////////
$ids = isset($_GET['ids'])?$_GET['ids']:""; 
$ids = substr($ids,0,-1);



////////////////LISTING////////////////////////////////

$userAlbumArray = array();
$qry = $objUserAlbums->PopulateGrid('*',' AND user_id = '.$objSession->id);	
$userAlbumArray = $objDb->getArray($qry);
//printArray($userAlbumArray);
?>
<script>
function sendLeaveType()
{  
	var errorfound = 0;
	var album_id = jQuery("#album_id").val();
	var ids = jQuery("#ids").val();
	//alert(album_id);alert(ids);
	 if(album_id=='' || album_id== null )
	 { 
		 jQuery("#message-error1").show();
		 jQuery("#all_msg1").html("Please select a Album.");
		 return false;
	 }
	jQuery.ajax({
		type	:	"GET",
		url		:	"ajax/update-album.php",
		data	: 	"album_id="+album_id+"&ids="+ids,
		async	: 	false,
		success :	function(rtnMsg)
		{ 
			jQuery.facebox.close(); 
			return true;
		} 
	});

}
</script>
<style>
.main td {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color: #393939;
	line-height:18px;
	position:relative;
	border:3px solid rgba(0, 0, 0, 0);
	padding:2px !important;
	border-radius:5px;/* 	-moz-box-shadow:0 0 18px rgba(0,0,0,0.4);
  	box-shadow:0 0 18px rgba(0,0,0,0.4);*/
}
.body {
	width:280px !important;
}
.errmsg {
	display:none;
}
</style>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>

<div class="heading2"><h1><strong>Move Image to Album</strong></h1></div>
<div class="fields"> 
  <!-- Start Error Message or Success Message -->
  
  <div class="message message-error " id="message-error1"  style="display:none;">
    <div class="text"> <span id="all_msg1">
      <?php if($error) { echo $error; }?>
      </span> </div>
    <div class="dismiss"> <a href="javascript:void(0);" onclick="jQuery('#message-error').fadeOut(1000);"></a></div>
  </div>
  
  <!-- End Error Message or Success Message --> 
  <!-- START FORM HERE  -->
  
  <form method="post" enctype="multipart/form-data">
    <div class="field">
      <div class="label">
        <label for="input-small"><h2>Select Album:&nbsp;</label>

        <input type="hidden" name="ids" id="ids" value="<?php echo $ids ?>"/>
        <select class="medium" name="album_id" id="album_id" >
          <option value="">Select album</option>
          <?php if(count($userAlbumArray)>0 )
					  {
						  foreach($userAlbumArray as $row)
						  {
				?>
          <option value="<?php echo $row['id']; ?>" >
          <?php  echo $row['album_name'] ;?>
          </option>
          <?php
                		  }
					  }
				 ?>
        </select></h3>
      </div>
    </div>
    <div class="buttons">
      <input type="submit" value="Save" name="btn_sub" id="btn_sub" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="return sendLeaveType();"  style=" cursor:pointer;">
      <div class="highlight"></div>
    </div>
  </form>
  
  <!-- END FORM HERE  --> 
</div>
