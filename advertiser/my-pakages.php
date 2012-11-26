<?php 
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session();
 
$objDb = new Database();
$objDb->connect();

$objMedia = new MediaType();
$objPakagePost = new PakagePost();
$start 	= intval(isset($_GET['start'])?$_GET['start']:"");
$act 	= isset($_GET['act'])?$_GET['act']:"";
$sortby		= isset($_GET['sortby'])?$_GET['sortby']:"";
$srch_cri	= "";
$catsrch		= isset($_POST['cat'])?$_POST['cat']:array();
$paging 	 = "";
$max		 = 10;
$page_limit  = 10;
$total 		 = 0;
$sqlMedia = $objMedia->PopulateGrid("*",' AND status = 1 ')." order by title";  
$media_Array = $objDb->getArray($sqlMedia);
//printArray($media_Array);


	$qry = ' AND status = 1 and id in(select pakage_id from pub_pakage_purchase where user_id='.$objSession->id.') ';
	$_pageurl = '';
	$linkURL = 'my-pakages.php?start='.$start;
	
	if(count($catsrch)>0)
	{
		$mediaIds = '';
		foreach($catsrch as $catsrchrow)
		{
			$mediaIds .= $catsrchrow.',';
		}
		$mediaIds = substr($mediaIds,0,-1);
		$qry .= ' AND media_id IN ('.$mediaIds.')';
		//echo $mediaIds = trim($mediaIds,',');
	}
	if(isset($_POST['srch_cri']))
	{
		$srch_cri	= isset($_POST['srch_cri'])?$_POST['srch_cri']:"";
		$qry .= ' AND pakage_title like "%'.$srch_cri.'%"';
	}
	if(!empty($act) and $sortby)
	{		
		$qry .= ' order by ';

		if($sortby == 1)
			$qry .= ' id desc ';		
		if($sortby == 2)
			$qry .= ' id asc ';	
		if($sortby == 3)
			$qry .= ' pakage_title asc ';								
		if($sortby == 4)
			$qry .= ' pakage_title desc ';
		
		$_pageurl .= "?act=sort&sortby=".$sortby;	
	}
	else 
		$qry .= " order by id desc";		


	$total = $objDb->GetCountSql($objPakagePost->table,$qry); 
	
	$paginate = new ClientPaginate($page_limit, $total, $_pageurl, $max);
	$paging   = $paginate->displayUl();
	$page 	  = $paginate->currentPage;
		
	$paginate->start = $paginate->start - 1;
	if($paginate->start<=0)
	{
		$paginate->start=0;
	} 
	
	$sqlPakagePost = $objPakagePost->PopulateGrid("*",$qry);
    $sqlPakagePost .= " LIMIT $paginate->start,$paginate->limit ;";
	$Data_Array = array();
	
	if($objDb->query($sqlPakagePost) and $objDb->get_num_rows()>0)
		while($Temp_Row = $objDb->fetch_row_assoc())
			array_push($Data_Array,$Temp_Row);

	//printArray($Data_Array);exit;
	/** Next previous limits for pagination **/
		
	$start = $paginate->start + 1;
	$limit = $paginate->limit;
				
	$pagError=0;
	if(($start+$limit) > $total)
	{
		$limit =  $total - $start;
		$pagError=1;
	}
	

?>
<!DOCTYPE html >
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/paginationclient.css" rel="stylesheet" type="text/css">
<script src="../js/lib/jquery.js"></script>
<script src="../js/modernizr.js"></script>
<script>
function goToLink(obj) 
{
	window.location='<?php echo $linkURL?>&act=sort&sortby='+obj.value;
}
</script>
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
      <div class="profile-blue-box"> <!-- first blue box -->
        <form method="post">
          <div class="search-bar-box">
            <div class="search-title">
              <label> Search Pakages </label>
            </div>
            <div class="search-bar">
              <input type="text" id="srch_cri" name="srch_cri" style="width:350px;" value="<?php echo $srch_cri;?>">
            </div>
            <div class="search-btn">
              <input type="submit" value="Search" id="srchBtn" name="srchBtn">
            </div>
          </div>
        </form>
        <form method="post" id="catForm" name="catForm">
          <div class="search-catagry-box">
            <div class="search-catagry-title">
              <label> Media </label>
            </div>
            <?php
          if(count($media_Array)>0)
		  {
			  //echo "asdfasdf";printArray($catsrch);
		  ?>
            <div class="search-catagry-row"> <!-- search-catagry-row -->
              
              <?php 
			foreach($media_Array as $media_row)
			{
				//echo "asfsadfsdf = ".in_array($media_row['id'],$catsrch)." asdfsdf id=".$media_row['id'];
			?>
              <div class="search-catagry-col">
                <div class="search-catagry-col-check-box">
                  <input type="checkbox" id="cat[]" name="cat[]"  value="<?php echo $media_row['id'];?>" on onClick="document.catForm.submit();" <?php if(in_array($media_row['id'],$catsrch)){echo 'checked';}?>>
                </div>
                <div class="search-catagry-col-title">
                  <label> <?php echo $media_row['title'];?> </label>
                </div>
              </div>
              <?php
			}
			?>
            </div>
            <?php 
		  }
		  else
		  {
			?>
            <div class="search-catagry-row"> <!-- search-catagry-row -->
              
              <div class="search-catagry-col">
                <div class="search-catagry-col-title">
                  <label> No categories found. </label>
                </div>
              </div>
            </div>
            <?php  
	      }
		  ?>
            <!-- search-catagry-row --> 
            
          </div>
        </form>
      </div>
      <!-- first blue box -->
      
      <div class="profile-third-white-box">
        <div class="job-list-all-job-box">
          <div class="job-list-search-result">
            <p class="job-list-total-jobs"> <?php echo $total;?> Pakages found </p>
            <label> Sort by: </label>
            <select id="sortby" name="sortby" onChange="goToLink(this);">
              <option value="1" <?php if($sortby==1){echo "selected";}?>> Newest </option>
              <option value="2" <?php if($sortby==2){echo "selected";}?>> Oldest </option>
              <option value="3" <?php if($sortby==3){echo "selected";}?>> Job Title Assending </option>
              <option value="4" <?php if($sortby==4){echo "selected";}?>> Job Title Descending </option>
            </select>
          </div>
          <div class="job-list-pagination">
            <div  class="paginationClass"><?php echo $paging;?></div>
          </div>
        </div>
        <?php
        if(count($Data_Array)>0)
		{
			foreach($Data_Array as $Data_row)
			{
		?>
        <div class="profile-third-box-detail job-list-margin">
          <div class="eductaion-heading"> <span class="job-post-title">
            <h3 onClick="window.location='pakage-detail.php?job=<?php echo $Data_row['id']?>'" style="cursor:pointer;"> <?php echo $Data_row['pakage_title'];?>. </h3>
            </span> <span class="apply-for-job-btn">
            <?php /*if($objSession->id!=0 and $objSession->user_type==ADVERTISER){?>
            <input type="button" value="Apply Now" onclick="window.location='<?php echo SITE_ROOT;?>advertiser/apply.php?job=<?php echo $Data_row['id']?>'">
            <?php }else{
				?>
            <input type="button" value="Login to apply" onClick="window.location='login.php'">
            <?php
			} */?>
            </span> </div>
          <div class="education-detail" style="margin-top:0px;">
            <p class="degree-year"> <span class="job-list-bold-text"> Fixed - Price </span> - Est, Budget: $<?php echo $Data_row['budget']?> - Posted on <?php echo hlpDateFormat($Data_row['dated']);?> </p>
            <p class="degree-decribtion" style="margin-top:5px; margin-bottom:15px;"> <?php echo $Data_row['pakage_desc']?> </p>
            <p class="degree-detail"> <span class="job-list-bold-text"> Last date: </span> <?php echo hlpDateFormat($Data_row['last_date']);?> </p>
          </div>
        </div>
        <?php
			}
		}
		else{
		?>
        <div class="profile-third-box-detail job-list-margin">
          <div class="eductaion-heading"> <span class="job-post-title">
            <h3>No jobs found. </h3>
            </span> </div>
        </div>
        <?php	
		}
		?>
      </div>
      <!-- profile-third-white-box --> 
      
    </div>
    <!-- profile warrper --> 
    
  </div>
  <!-- content --> 
  
  <!-- footer -->
  <?php include('../includes/footer.php');?>
</div>
<!-- Warpper -->

</body>
</html>
