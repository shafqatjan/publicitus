<div class="logo_cell"> <a href="./" style="float: left;" class="logo"></a>
  <div style=""><img src="images/blank.gif" alt="blank" width="0" height="0"></div>
  <ul id="navlink">
    <li><a href="./" class="navlink">Upload</a></li>
    <?php
    if($objSession->id)
	{
	?>
    <li><a href="my_images.php" class="navlink">My Images</a></li>
    <li><a href="my_albums.php" class="navlink">My Albums</a></li>
<!--    <li><a href="statistics.php" class="navlink">Statistics</a></li>-->
    <?php
	}
    ?>
    <li><a href="premium.php" class="navlink">Premium</a></li>
    <li><a href="affiliate.php" class="navlink">Affiliate</a></li>
  </ul>
</div>
