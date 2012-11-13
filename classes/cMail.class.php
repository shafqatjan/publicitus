<?php
//** the newline character(s) to be used when generating an email message. 
define("EmailNewLine", "\r\n");

//** the default charset values for both text and HTML emails. 
define("DefaultCharset", "iso-8859-1");

class cMail
{
	private $RepName;
	private $To;
	private $Cc; 
	private $Bcc; 
	private $From; 
	private $Subject; 
	private $BodyMsg;
	private $Content;
	private $Attachments; 
	private $Headers; 
	private $TextOnly; 
	private $Charset; 
	
	private $LinkType;
	
	public function __construct()
	{
		$this->RepName = "";
		$this->To = "";
		$this->Cc = ""; 
		$this->Bcc = ""; 
    	$this->From = EMAIL_NO_REPLY; 
    	$this->Subject = ""; 
    	$this->Headers = "";
		$this->BodyMsg = "";
		$this->Content = "";
		$this->TextOnly = false; 
		$this->Charset = "";

		$this->Attachments = Array();
    	$this->Attachments["text"] = null;
    	$this->Attachments["html"] = null;
	}
	
	public function __set($field, $value)
	{
		$this->$field = $value;
	}
	
	public function __get($field)
	{
		return $this->$field;
	}
	
	//** Returns: MIME Type 
	//** Check the file MIME type in already MIME Types define array
	//** given. If the MIME Type cannot be located  
	//** application/octet-stream is returned.
	private function GetMimeType($filename)
	{
		$filename = basename($filename);

      	// break file into parts seperated by .
      	$filename = explode('.', $filename);

      	// take the last part of the file to get the file extension
      	$filename = $filename[count($filename)-1];
	  
		$mimeTypesArray = array("ez" => "application/andrew-inset",
         "hqx" => "application/mac-binhex40",
         "cpt" => "application/mac-compactpro",
         "doc" => "application/msword",
         "bin" => "application/octet-stream",
         "dms" => "application/octet-stream",
         "lha" => "application/octet-stream",
         "lzh" => "application/octet-stream",
         "exe" => "application/octet-stream",
         "class" => "application/octet-stream",
         "so" => "application/octet-stream",
         "dll" => "application/octet-stream",
         "oda" => "application/oda",
         "pdf" => "application/pdf",
         "ai" => "application/postscript",
         "eps" => "application/postscript",
         "ps" => "application/postscript",
         "smi" => "application/smil",
         "smil" => "application/smil",
         "wbxml" => "application/vnd.wap.wbxml",
         "wmlc" => "application/vnd.wap.wmlc",
         "wmlsc" => "application/vnd.wap.wmlscriptc",
         "bcpio" => "application/x-bcpio",
         "vcd" => "application/x-cdlink",
         "pgn" => "application/x-chess-pgn",
         "cpio" => "application/x-cpio",
         "csh" => "application/x-csh",
         "dcr" => "application/x-director",
         "dir" => "application/x-director",
         "dxr" => "application/x-director",
         "dvi" => "application/x-dvi",
         "spl" => "application/x-futuresplash",
         "gtar" => "application/x-gtar",
         "hdf" => "application/x-hdf",
         "js" => "application/x-javascript",
         "skp" => "application/x-koan",
         "skd" => "application/x-koan",
         "skt" => "application/x-koan",
         "skm" => "application/x-koan",
         "latex" => "application/x-latex",
         "nc" => "application/x-netcdf",
         "cdf" => "application/x-netcdf",
         "sh" => "application/x-sh",
         "shar" => "application/x-shar",
         "swf" => "application/x-shockwave-flash",
         "sit" => "application/x-stuffit",
         "sv4cpio" => "application/x-sv4cpio",
         "sv4crc" => "application/x-sv4crc",
         "tar" => "application/x-tar",
         "tcl" => "application/x-tcl",
         "tex" => "application/x-tex",
         "texinfo" => "application/x-texinfo",
         "texi" => "application/x-texinfo",
         "t" => "application/x-troff",
         "tr" => "application/x-troff",
         "roff" => "application/x-troff",
         "man" => "application/x-troff-man",
         "me" => "application/x-troff-me",
         "ms" => "application/x-troff-ms",
         "ustar" => "application/x-ustar",
         "src" => "application/x-wais-source",
         "xhtml" => "application/xhtml+xml",
         "xht" => "application/xhtml+xml",
         "zip" => "application/zip",
         "au" => "audio/basic",
         "snd" => "audio/basic",
         "mid" => "audio/midi",
         "midi" => "audio/midi",
         "kar" => "audio/midi",
         "mpga" => "audio/mpeg",
         "mp2" => "audio/mpeg",
         "mp3" => "audio/mpeg",
         "aif" => "audio/x-aiff",
         "aiff" => "audio/x-aiff",
         "aifc" => "audio/x-aiff",
         "m3u" => "audio/x-mpegurl",
         "ram" => "audio/x-pn-realaudio",
         "rm" => "audio/x-pn-realaudio",
         "rpm" => "audio/x-pn-realaudio-plugin",
         "ra" => "audio/x-realaudio",
         "wav" => "audio/x-wav",
         "pdb" => "chemical/x-pdb",
         "xyz" => "chemical/x-xyz",
         "bmp" => "image/bmp",
         "gif" => "image/gif",
         "ief" => "image/ief",
         "jpeg" => "image/jpeg",
         "jpg" => "image/jpeg",
         "jpe" => "image/jpeg",
         "png" => "image/png",
         "tiff" => "image/tiff",
         "tif" => "image/tif",
         "djvu" => "image/vnd.djvu",
         "djv" => "image/vnd.djvu",
         "wbmp" => "image/vnd.wap.wbmp",
         "ras" => "image/x-cmu-raster",
         "pnm" => "image/x-portable-anymap",
         "pbm" => "image/x-portable-bitmap",
         "pgm" => "image/x-portable-graymap",
         "ppm" => "image/x-portable-pixmap",
         "rgb" => "image/x-rgb",
         "xbm" => "image/x-xbitmap",
         "xpm" => "image/x-xpixmap",
         "xwd" => "image/x-windowdump",
         "igs" => "model/iges",
         "iges" => "model/iges",
         "msh" => "model/mesh",
         "mesh" => "model/mesh",
         "silo" => "model/mesh",
         "wrl" => "model/vrml",
         "vrml" => "model/vrml",
         "css" => "text/css",
         "html" => "text/html",
         "htm" => "text/html",
         "asc" => "text/plain",
         "txt" => "text/plain",
         "rtx" => "text/richtext",
         "rtf" => "text/rtf",
         "sgml" => "text/sgml",
         "sgm" => "text/sgml",
         "tsv" => "text/tab-seperated-values",
         "wml" => "text/vnd.wap.wml",
         "wmls" => "text/vnd.wap.wmlscript",
         "etx" => "text/x-setext",
         "xml" => "text/xml",
         "xsl" => "text/xml",
         "mpeg" => "video/mpeg",
         "mpg" => "video/mpeg",
         "mpe" => "video/mpeg",
         "qt" => "video/quicktime",
         "mov" => "video/quicktime",
         "mxu" => "video/vnd.mpegurl",
         "avi" => "video/x-msvideo",
         "movie" => "video/x-sgi-movie",
         "ice" => "x-conference-xcooltalk");
		
		if(isset($mimeTypesArray[$ext]))
	  	{
        	return $mimeTypesArray[$ext];
      	}
	  	else //// if the extension wasn't found return octet-stream
	  	{
        	return 'application/octet-stream';
      	}
	
	}
	
	private function SetMultipartAlternative($text=null, $html=null)
	{
    	if(strlen(trim(strval($html))) == 0 || strlen(trim(strval($text))) == 0)
      		return false;
    	else
    	{
			//** create the text email attachment based on the text given and the standard
			//** plain text MIME type.

			$this->Attachments["text"] = new EmailAttachment(null, "text/plain");
		  	$this->Attachments["text"]->LiteralContent = strval($text);
	
			//** create the html email attachment based on the HTML given and the standard
			//** html text MIME type.
	
		  	$this->Attachments["html"] = new EmailAttachment(null, "text/html");
		  	$this->Attachments["html"]->LiteralContent = strval($html);
	
			return true; //** operation was successful.
		}
	}
	
	
	//** Returns: Boolean 
	//** Create a new file attachment for the file (and optionally MIME type) 
	//** given. If the file cannot be located no attachment is created and 
	//** FALSE is returned. 

	public function Attach($pathtofile) 
	{ 
		//** create the appropriate email attachment. If the attachment does not 
		//** exist the attachment is not created and FALSE is returned. 
		
		$mimetype = $this->GetMimeType($pathtofile);
		$attachment = new EmailAttachment($pathtofile, $mimetype);
		
    	if(!$attachment->Exists()) 
      		return false; 
    	else 
    	{ 
      		$this->Attachments[] = $attachment;  //** add the attachment to list. 
      		return true;                         //** attachment successfully added. 
    	} 
	}
	
	//** Returns: Boolean 
	//** Determine whether or not the email message is ready to be sent. A TO and 
	//** FROM address are required. 

	private function IsComplete() 
	{ 
    	return (strlen(trim($this->To)) > 0 && strlen(trim($this->From)) > 0); 
  	}
	
	
	public function SendEmail()
  	{
    	
		if(!$this->IsComplete())  //** message is not ready to send. 
      	{

			return false;           //** no message will be sent. 
		}
		//** generate a unique boundry identifier to separate attachments. 
		$theboundary = "-----" . md5(uniqid("EMAIL")); 

		//** the from email address and the current date of sending. 
		$headers = "Date: " . date("r", time()) . EmailNewLine .
               "From: $this->From" . EmailNewLine;

		//** if a non-empty CC field is provided add it to the headers here.
    	if(strlen(trim(strval($this->Cc))) > 0)
      		$headers .= "CC: $this->Cc" . EmailNewLine;
    
		//** if a non-empty BCC field is provided add it to the headers here.
		if(strlen(trim(strval($this->Bcc))) > 0)
      		$headers .= "BCC: $this->Bcc" . EmailNewLine;

		//** add the custom headers here, before important headers so that none are 
		//** overwritten by custom values. 
    	if($this->Headers != null && strlen(trim($this->Headers)) > 0) 
      		$headers .= $this->Headers . EmailNewLine; 

		//** determine whether or not this email is mixed HTML and text or both.
    	$isMultipartAlternative = ($this->Attachments["text"] != null &&
        	$this->Attachments["html"] != null);

		//** determine the correct MIME type for this message.
    	$baseContentType = "multipart/" . ($isMultipartAlternative ? 
                                       "alternative" : "mixed");

		//** add the custom headers, the MIME encoding version and MIME typr for the 
		//** email message, the boundry for attachments, the error message if MIME is 
		//** not suppported. 
    	$headers .= "X-Mailer: " . EmailNewLine . 
                "MIME-Version: 1.0" . EmailNewLine . 
                "Content-Type: $baseContentType; " .
                "boundary=\"$theboundary\"" . EmailNewLine . EmailNewLine; 

		//** if a multipart message add the text and html versions of the content.

    	if($isMultipartAlternative)
    	{
			//** add the text and html versions of the email content.

      		$thebody = "--$theboundary" . EmailNewLine . 
                  $this->Attachments["text"]->ToHeader() . EmailNewLine .
                 "--$theboundary" . EmailNewLine . 
                  $this->Attachments["html"]->ToHeader() . EmailNewLine; 
    	}
		else //** if either only html or text email add the content to the email body.
    	{
			//** determine the proper encoding type and charset for the message body. 

			$theemailtype = "text/" . ($this->TextOnly ? "plain" : "html"); 
			if($this->Charset == null) 
        		$this->Charset = DefaultCharset;

			$tempEmailHeader = "";
			if(!empty($this->RepName))
				$tempEmailHeader .= 'Hi '.htmlspecialchars_decode(stripslashes($this->RepName)).',<br>';
			$tempEmailHeader .= $this->BodyMsg.'<br><br>';
			
			$tempEmailFooter = "<hr><br />If you think you've received this email in error, or if you have any questions or concerns regarding your privacy, please contact us at:<br>";
			$tempEmailFooter .= EMAIL_INFO."<br /><br />";
			$tempEmailFooter .= EMAIL_SIGNATURE;
			
			$fullMsg = $tempEmailHeader.$this->Content.$tempEmailFooter;
			
			//** add the encoding header information for the body to the content. 
			
      		$thebody = "--$theboundary" . EmailNewLine . 
                 "Content-Type: $theemailtype; charset=$this->Charset" . 
                  EmailNewLine . "Content-Transfer-Encoding: 8bit" . 
                  EmailNewLine . EmailNewLine .$fullMsg. 
                  EmailNewLine . EmailNewLine; 

			//** loop over the attachments for this email message and attach the files 
			//** to the email message body. Only if not multipart alternative.

      		foreach($this->Attachments as $attachment) 
      		{
				 //** check for NULL attachments used by multipart alternative emails. Do not
 				//** attach these.
        		if($attachment != null)
        		{
          			$thebody .= "--$theboundary" . EmailNewLine . 
                    $attachment->ToHeader() . EmailNewLine; 
        		}
      		} 
		}
		
		//** end boundry marker is required.
		$thebody .= "--$theboundary--"; 
		
		//** attempt to send the email message. Return the operation success. 
		
		
/*		echo $headers;
		echo "<br>To<br>".$this->To;
		echo "<br>Sub<br>".$this->Subject;
		echo "<br />Body<br>".$thebody;
		echo "<br><br><br>";
*/
		
		return @mail($this->To, $this->Subject, $thebody, $headers); 
		
	}
	
	private function getRole($roleId)
	{
		switch($roleId)
		{
			case 1:
				return CLIENT_DIR;
			break;
			case 3: 
				return DEVELOPER_DIR;
			break;
			case 2: 
				return MANAGER_DIR;
			break;
			case 4: 
				return BDO_DIR;
			break;
			case 6: 
				return ADMIN_DIR;
			break;
		}

	}
	
	
	public function newProject($email,$username,$insert_id,$projectName,$roleId)
	{
		$folder = $this->getRole($roleId);
		
		$this->To = $email;
		$this->Cc = "";
		$this->Bcc = "";
		$this->RepName = htmlspecialchars_decode(stripslashes($username));
		$this->Subject = "Project ".$projectName." Added on Project Tracking System";
		$this->From = EMAIL_NO_REPLY;
		$this->TextOnly = false;
		
		//$message = 'Hi '.htmlspecialchars_decode(stripslashes($username)).',<br>';
		$message = 'A project '.$projectName.'. is added to your PTS Account <br><br>';
		$message .= DOC_ROOT.$folder."project-detail.php?project=".$insert_id."<br>";
		$message .= '(If this link is not clickable, copy and paste the address into your web browser address bar)<br><br><br>';				
		$this->Content = $message;
			
		$this->SendEmail();
	}
	
	public function DeleteUser($email,$username, $projectName)
	{
		$folder = $this->getRole($roleId);
		
		$this->To = $email;
		$this->Cc = "";
		$this->Bcc = "";
		$this->Subject = "Project ".$projectName." update on Project Tracking System";
		$this->From = EMAIL_NO_REPLY;
		$this->TextOnly = false;
		
		$message = 'Hi '.htmlspecialchars_decode(stripslashes($username)).',<br>';	
		$message .= 'Your current designation on '.$projectName.'. has been removed.<br><br>';					
		$message .= '<hr>';
		$message .= "If you think you've received this email in error, or if you have any questions or concerns regarding your privacy, please contact us at:<br>";	
		$message .= EMAIL_INFO."<br /><br />";
		$message .= EMAIL_SIGNATURE;
		
		$this->Content = $message;
			
		$this->SendEmail();	
		
	}
	
	public function newFeedbackReply($username,$feedbackId,$roleId, $email)
	{
		$folder = $this->getRole($roleId);		
		
		$this->To = $email;
		$this->Cc = "";
		$this->Bcc = "";
		$this->Subject = "A Reply is added on Your Feedback";
		$this->From = EMAIL_NO_REPLY;
		$this->TextOnly = false;
		
		$message = 'Hi '.htmlspecialchars_decode(stripslashes($username)).',<br>';
		$message .= 'A reply is added to below feedback<br><br>';
		$message .= DOC_ROOT.$folder.'feedback-detail.php?feedback='.$feedbackId.'<br><br>';
		$message .= '(If this link is not clickable, copy and paste the address into your web browser address bar)<br><br><br>';
		$message .= '<hr>';	
		$message .= "If you think you've received this email in error, or if you have any questions or concerns regarding your privacy, please contact us at:<br>";	
		$message .= EMAIL_INFO."<br /><br />";
		$message .= EMAIL_SIGNATURE;
		
		$this->Content = $message;
			
		$this->SendEmail();	
		
	}
	
	public function taskCreated($username,$roleid,$taskId, $email)
	{
		$folder = $this->getRole($roleId);
		
		$this->To = $email;
		$this->Cc = "";
		$this->Bcc = "";
		$this->Subject = "Task Created For You";
		$this->From = EMAIL_NO_REPLY;
		$this->TextOnly = false;
		
		$message = 'Hi '.htmlspecialchars_decode(stripslashes($username)).',<br>';
		$message .= 'A Task has been created for you<br><br>';
		$message .= DOC_ROOT.$folder.'todo-detail.php?ticket='.$taskId.'<br><br>';
		$message .= '(If this link is not clickable, copy and paste the address into your web browser address bar)<br><br><br>';
		$message .= '<hr>';
		$message .= "If you think you've received this email in error, or if you have any questions or concerns regarding your privacy, please contact us at:<br>";
		$message .= EMAIL_INFO."<br /><br />";
		$message .= EMAIL_SIGNATURE;
		
		$this->Content = $message;
			
		$this->SendEmail();
		
	}
	
	/*
	function addFeedback()
	{
		$folder = "";
		
		switch($userArray['roleId'])
		{
			case 1:
				$folder = "client";
				break;
			case 2: 
				$folder = "manager";
				break;
			case 4: 
				$folder = "bdo";
				break;
			case 2: 
				$folder = "admin";
				break;
					}
					
					
					$to = $userArray['email'];

					$subject = "Project Tracking System Feedback on ".$projectArray['name'];

					$message = 'Hi '.htmlspecialchars_decode(stripslashes($userArray['name'])).',<br>';

					$message .= 'A feedback is added to '.$projectArray['name'].'. Click below link to View feedback <br><br>';
					
					$message .= DOC_ROOT.$folder."/feedback-detail.php?feedback=".$insert_id."<br>";

					$message .= '(If this link is not clickable, copy and paste the address into your web browser address bar)<br><br><br>';

				
					$message .= 'Regards PTS.!<br>';

					$message .= '<hr>';

					$message .= "If you think you've received this email in error, or if you have any questions or concerns regarding your privacy, please contact us at:<br>";

					$message .= 'info@pts.com<br><br>';

					$message .= 'Regards,<br>Project Tracking System<br>';

	
					
					$from = "no-reply@pts.com";

					$headers  = "From: ". $from;
	
					$headers .= "\r\nMIME-Version: 1.0\r\n";

					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n<br>";



					@mail($to, $subject, $message, $headers);
	
	}
	*/
}

//**EMAIL_ATTACHMENT_CLASS_DEFINITION***************************************** 
//** The EmailAttachment class links a file in the file system to the 
//** appropriate header to be included in an email message. if the file does 
//** not exist the attachment will not be sent in any email messages. It can
//** also be used to generate an attachment from literal content provided.

class EmailAttachment 
{ 
	//** (String) the full path to the file to be attached. 
	var $FilePath = null; 

	//** (String) the MIME type for the file data of this attachment. 
	var $ContentType = null; 

	//** binary content to be used instead the contents of a file.
	var $LiteralContent = null;

	//** Creates a new email attachment ffrom the file path given. If no content 
	//** type is given the default 'application/octet-stream' is used. 

	function EmailAttachment($pathtofile=null, $mimetype=null) 
	{ 
		//** if no MIME type is provided use the default value specifying binary data. 
		//** Otherwise use the MIME type provided. 

	if($mimetype == null || strlen(trim($mimetype)) == 0) 
		$this->ContentType = "application/octet-stream"; 
    else 
		$this->ContentType = $mimetype; 

    $this->FilePath = $pathtofile;  //** save the path to the file attachment. 
	
	} 
	
	//** Returns: Boolean
	//** Determine whether literal content is provided and should be used as the
	//** attachment rather than a file.

	function HasLiteralContent()
	{
    	return (strlen(strval($this->LiteralContent)) > 0);
  	}

	//** Returns: String 
	//** Get the binary string data to be used as this attachment. If literal
	//** content is provided is is used, otherwise the contents of the file path
	//** for this attachment is used. If no content is available NULL is returned.

	function GetContent()
	{
		//** non-empty literal content is available. Use that as the attachment.
		//** Assume the user has used correct MIME type.

		if($this->HasLiteralContent())
			return $this->LiteralContent;
		else //** no literal content available. Try to get file data.
		{
      		if(!$this->Exists())  //** file does not exist.
        		return null;        //** no content is available.
      		else //** open the file attachment in binary mode and read the contents. 
      		{
				$thefile = fopen($this->FilePath, "rb"); 
				$data = fread($thefile, filesize($this->FilePath));
				fclose($thefile);
        		return $data; 
      		}
    	}
	}

	//** Returns: Boolean 
	//** Determine whether or not the email attachment has a valid, existing file 
	//** associated with it. 

	function Exists() 
	{ 
		if($this->FilePath == null || strlen(trim($this->FilePath)) == 0) 
      		return false; 
    	else 
      		return file_exists($this->FilePath); 
  	}
	
	//** Returns: String 
	//** Generate the appropriate header string for this email attachment. If the 
	//** the attachment content does not exist NULL is returned. 

	function ToHeader() 
	{ 
		$attachmentData = $this->GetContent();  //** get content for the header.
		if($attachmentData == null)             //** no valid attachment content.
      		return null;                          //** no header can be generted. 

		//** add the content type and file name of the attachment. 
		$header = "Content-Type: $this->ContentType;"; 

		//** if an attachment then add the appropriate disposition and file name(s).
		if(!$this->HasLiteralContent())
    	{
      		$header .= " name=\"" . basename($this->FilePath) . "\"" . EmailNewLine .
                 "Content-Disposition: attachment; filename=\"" . 
                  basename($this->FilePath) . "\""; 
		}
    
		$header .= EmailNewLine;

		//** add the key for the content encoding of the attachment body to follow. 
		$header .= "Content-Transfer-Encoding: base64" . EmailNewLine . 
                EmailNewLine; 

		//** add the attachment data to the header. encode the binary data in BASE64 
		//** and break the encoded data into the appropriate chunks. 

    	$header .= chunk_split(base64_encode($attachmentData), 76, EmailNewLine) .
               EmailNewLine; 

    	return $header;  //** return the headers generated by file. 
  	}
	

}

?>