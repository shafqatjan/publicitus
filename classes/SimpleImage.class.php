<?php

class SimpleImage
{
	var $image;
	var $image_type;

	function uploadFile($fileName, $updDir, $isImage=1, $makeThumb=0, $w = 0, $h = 0, $keepMain = 0, $mW = 0, $mH=0, $oldImage='')
	{
		printArray(func_get_args());
		$rtn = array();
		$rtn['error'] = 1;
		if(intval($rtn['error']))
		{
			$rtn['error'] = 0;
			$ext = substr(strrchr($_FILES[$fileName]['name'], '.'), 1);
			$new_name = rand().'_'.time().'_'.date("Ydm").'.'.$ext;

			list($org_width, $org_height, $type, $attr) = getimagesize($_FILES[$fileName]['tmp_name']);
			
			if(move_uploaded_file($_FILES[$fileName]['tmp_name'], $updDir.$new_name))
			{

				if($makeThumb)
				{
					$this->load($updDir.$new_name);
					$this->resize($w,$h);
					$this->save($updDir.'thumb_'.$new_name);
					echo $rtn['thumb'] = 'thumb_'.$new_name;
					echo $_FILES[$fileName]['tmp_name'];exit;					
					sleep(2);
					if($keepMain)
					{
						if($mW && $mH)
							$this->resize($mW,$mH);
						else
							$this->resize($org_width,$org_height);
						
						$this->save($updDir.'main_'.$new_name);
						sleep(2);
						$rtn['file'] = 'main_'.$new_name;
					}
					
					@unlink($updDir.$new_name);
				}
				else
					$rtn['file'] = $new_name;
			}
		}
		
		return $rtn;
	}
	function uploadFileExt($fileName, $updDir, $isImage=1, $makeThumb=1, $w = 0, $h = 0, $keepMain = 0, $mW = 0, $mH=0, $oldImage='')
	{
		//printArray(func_get_args());
		$rtn = array();
		$rtn['error'] = 1;
		if(intval($rtn['error']))
		{
			$rtn['error'] = 0;
			$ext = substr(strrchr($_FILES[$fileName]['name'], '.'), 1);
			$new_name = time().'_'.date("Ydm").'.'.$ext;
			//echo $_FILES[$fileName]['tmp_name'];
			list($org_width, $org_height, $type, $attr) = getimagesize($_FILES[$fileName]['tmp_name']);
			
			if(move_uploaded_file($_FILES[$fileName]['tmp_name'], $updDir.$new_name))
			{
				if($makeThumb)
				{
					$this->load($updDir.$new_name);
					$this->resize($w,$h);
					$this->save($updDir.'thumb_'.$new_name);
					$rtn['thumb'] = 'thumb_'.$new_name;
					sleep(2);
					if($keepMain)
					{
						if($mW && $mH)
							$this->resize($mW,$mH);
						else
							$this->resize($org_width,$org_height);
						
						$this->save($updDir.'main_'.$new_name);
						sleep(2);
						$rtn['file'] = 'main_'.$new_name;
					}
					@unlink($updDir.$new_name);
				}
				else
					$rtn['file'] = $new_name;
			}
		}
		
		return $rtn;
	}	
	
	function load($filename)
	{
		echo  $filename;
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		
		if( $this->image_type == IMAGETYPE_JPEG)
		{
			$this->image = imagecreatefromjpeg($filename);
		}
		elseif($this->image_type == IMAGETYPE_GIF)
		{
			$this->image = imagecreatefromgif($filename);
		}
		elseif($this->image_type == IMAGETYPE_PNG)
		{
			$this->image = imagecreatefrompng($filename);
		}
	}
	
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null)
	{
		if( $image_type == IMAGETYPE_JPEG)
		{
			imagejpeg($this->image,$filename,$compression);
		}
		elseif( $image_type == IMAGETYPE_GIF)
		{
			imagegif($this->image,$filename);
		}
		elseif($image_type == IMAGETYPE_PNG)
		{
			imagepng($this->image,$filename);
		}
		
		if($permissions != null)
		{
			chmod($filename,$permissions);
		}
	}
	
	function output($image_type=IMAGETYPE_JPEG)
	{
		if( $image_type == IMAGETYPE_JPEG)
		{
			imagejpeg($this->image);
		}
		elseif($image_type == IMAGETYPE_GIF)
		{
			imagegif($this->image);
		}
		elseif($image_type == IMAGETYPE_PNG)
		{
			imagepng($this->image);
		}
	}

	function getWidth()
	{
		return imagesx($this->image);
	}

	function getHeight()
	{
		return imagesy($this->image);
	}

	function resizeToHeight($height)
	{
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
	}
	
   	function resizeToWidth($width)
	{
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);
	}

	function scale($scale)
	{
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100; 
		$this->resize($width,$height);
	}
	
	function resize($width,$height)
	{
		$new_image = imagecreatetruecolor($width, $height);
      	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      	$this->image = $new_image;
   }

}
?>