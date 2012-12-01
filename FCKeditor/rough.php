<?php
include_once("fckeditor/fckeditor.php") ;
?>

  <form  method="post">
<?php
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = '/fckeditor/' ;
$oFCKeditor->Value = '<p>This is some <strong>sample text</strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor</a>.</p>' ;
$oFCKeditor->Create() ;
?>
   <input type="submit" value="Submit">
  </form>

