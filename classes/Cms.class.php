<?php

class Cms
{

	private $id; //int(11)
	private $page_title; //varchar(255)
	private $page_heading; //varchar(255)
	private $page_name; //varchar(255)
	private $page_content; //varchar(255)
	private $email; //varchar(255)	
	private $contact_no; //varchar(255)
	private $meta_tag; //varchar(255)	
	private $table;

	public function __construct()
	{
		$this->page_title = '';
		$this->page_heading = '';
		$this->page_name = '';
		$this->page_content = '';
		$this->email = '';
		$this->contact_no = '';
		$this->meta_tag = '';
		$this->table = TBL_CMS;
	}

	public function __set($field, $val)
	{
		if(is_array($val))
		{
			foreach($val as $key=>$value)
				if(isset($this->$key))
					$this->$key = $value;	
		}
		else
			$this->$field = $val;
	}

	public function __get($var)
	{
		return $this->$var;
	}
	public function validateCms()
	{
		

		$error = '';
		if(!$this->id)
			$error .= '&nbsp;&bull;&nbsp;Please select page.<br />';
		if(!$this->page_title)
			$error .= '&nbsp;&bull;&nbsp;Page title cannot be left blank.<br />';
		if(!$this->page_heading)
			$error .= '&nbsp;&bull;&nbsp;Page heading cannot be left blank.<br />';		
		if(!$this->page_content)
			$error .= '&nbsp;&bull;&nbsp;Page content cannot be left blank.<br />';
/*		if(!$this->email && $this->id==3)
			$error .= '&nbsp;&bull;&nbsp;'.$emialIdBlankMsgMenu.'<br />';
		else if(!hlpValidEmail($this->email) && $this->id==3)
			$error .= '&nbsp;&bull;&nbsp;Invalid email.<br />';		
		if(!$this->contact_no)
			$error .= '&nbsp;&bull;&nbsp;'.$contactNumberMsgMenu.'<br />';*/
		return $error;
	}	

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		page_title = '".hlpMysqlRealScape($this->page_title)."', 
		page_heading = '".hlpMysqlRealScape($this->page_heading)."', 
		page_name = '".hlpMysqlRealScape($this->page_name)."', 
		page_content = '".hlpMysqlRealScape($this->page_content)."', 
		email = '".hlpMysqlRealScape($this->email)."', 
		contact_no = '".hlpMysqlRealScape($this->contact_no)."', 
		meta_tag = '".hlpMysqlRealScape($this->meta_tag)."';";
	}

	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		page_title = '".hlpMysqlRealScape($this->page_title)."', 
		page_heading = '".hlpMysqlRealScape($this->page_heading)."', 
		page_content = '".hlpMysqlRealScape($this->page_content)."', 
		email = '".hlpMysqlRealScape($this->email)."', 
		meta_tag = '".hlpMysqlRealScape($this->meta_tag)."'
		WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($params = '*', $whr_clz='')
	{
		return 'SELECT '.$params.' FROM '.$this->table.' WHERE 1=1 '.$whr_clz;
	}
	public function UpdateContactNo()
	{
		return 'UPDATE '.$this->table.' SET contact_no 	= "'.$this->contact_no.'"';
	}
	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}
}

?>