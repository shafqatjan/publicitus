
<?php
define('APACHE_MIME_TYPES_URL','http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');

function get_mime_type($filename, $mimePath = '../etc') {
   $fileext = substr(strrchr($filename, '.'), 1);
   if (empty($fileext)) return (false);
   $regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
   $lines = file("$mimePath");
   foreach($lines as $line) {
      if (substr($line, 0, 1) == '#') continue; // skip comments
      $line = rtrim($line) . " ";
      if (!preg_match($regex, $line, $matches)) continue; // no match to the extension
      return ($matches[1]);
   }
   return (false); // no match at all
} 
$filename = 'index.php';
echo get_mime_type($filename,APACHE_MIME_TYPES_URL);
exit;
function generateUpToDateMimeArray($url){
    $s=array();
    foreach(@explode("\n",@file_get_contents($url))as $x)
        if(isset($x[0])&&$x[0]!=='#'&&preg_match_all('#([^\s]+)#',$x,$out)&&isset($out[1])&&($c=count($out[1]))>1)
            for($i=1;$i<$c;$i++)
                $s[]='&nbsp;&nbsp;&nbsp;\''.$out[1][$i].'\' => \''.$out[1][0].'\'';
    return @sort($s)?'$mime_types = array(<br />'.implode($s,',<br />').'<br />);':false;
}

echo
generateUpToDateMimeArray(APACHE_MIME_TYPES_URL);
?>