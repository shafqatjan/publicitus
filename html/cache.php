<?php
// TOP of your script  
$cachefile = basename($_SERVER['SCRIPT_NAME']);  
$cachetime = 120 * 60; // 2 hours  
// Serve from the cache if it is younger than $cachetime  
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {  
include($cachefile);  
echo "<!-- Cached ".date('jS F Y H:i', filemtime($cachefile))." -->";  
exit;  
}  
ob_start(); // start the output buffer  
// Your normal PHP script and HTML content here  
// BOTTOM of your script  
$fp = fopen($cachefile, 'w'); // open the cache file for writing  
fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file  
fclose($fp); // close the file  
ob_end_flush(); // Send the output to the browser 
?>