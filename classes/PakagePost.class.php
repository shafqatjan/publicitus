<?php

class PakagePost
{

	private $id; //int(11)
	private $pakage_title; //varchar(70)
	private $pakage_desc; //varchar(70)	
	private $budget; //varchar(70)
	private $media_id; //varchar(70)
	private $last_date; //tinyint(3)
	private $status;
	private $dated;
	private $duration;
	private $user_id;

	public function __construct()
	{
		$this->id='';
		$this->pakage_title= '';
		$this->pakage_desc = '';
		$this->last_date = '';
		$this->media_id= '';
		$this->duration = '';
		$this->status = '';
		$this->dated = '';
		$this->table = TBL_PAKAGE_POST;
		$this->user_id='';
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
	
	public function validate()
	{
		$error='';
		if($this->pakage_title == '')
			$error .= '&nbsp;&bull;&nbsp;Pakage Title cannot be left blank.<br>';
		if($this->pakage_desc == '')
			$error .= '&nbsp;&bull;&nbsp;Pakage Description cannot be left blank.<br>';
		 if($this->media_id == '')
			$error .= '&nbsp;&bull;&nbsp;Media can no blank.<br>';		
		if($this->budget == '')
			$error .= '&nbsp;&bull;&nbsp;Budget cannot be left blank.<br>';
		else if(!is_double($this->budget))
			$error .= '&nbsp;&bull;&nbsp;Float Allowed.<br>';
			if($this->duration == '')
			$error .= '&nbsp;&bull;&nbsp;Duration cannot be left blank.<br>';
			else if(!is_numeric($this->duration))
			$error .= '&nbsp;&bull;&nbsp;Number Allowed.<br>';
		if($this->last_date == '')
			$error .= '&nbsp;&bull;&nbsp;Last Date cannot be left blank.<br>';
		if(time()>=strtotime($this->last_date))
			$error .= '&nbsp;&bull;&nbsp;Last Date cannot be less than from current date.<br>';
		return $error;
	}


	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		pakage_title = '".hlpMysqlRealScape($this->pakage_title)."', 
		pakage_desc = '".hlpMysqlRealScape($this->pakage_desc)."', 
		budget = '".hlpMysqlRealScape($this->budget)."', 
		media_id = '".hlpMysqlRealScape($this->media_id)."', 
		last_date = '".hlpMysqlRealScape($this->last_date)."',
		duration = '".hlpMysqlRealScape($this->duration)."',
		user_id = '".hlpMysqlRealScape($this->user_id)."',  
		status = '".hlpMysqlRealScape($this->status)."';";
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		pakage_title = '".hlpMysqlRealScape($this->pakage_title)."', 
		pakage_desc = '".hlpMysqlRealScape($this->pakage_desc)."', 
		budget = '".hlpMysqlRealScape($this->budget)."', 
		media_id = '".hlpMysqlRealScape($this->media_id)."', 
		last_date = '".hlpMysqlRealScape($this->last_date)."', 
		duration = '".hlpMysqlRealScape($this->duration)."', 
		status = '".hlpMysqlRealScape($this->status)."' 
		WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($pram='*',$whr_clz='')
	{ 
		return "SELECT ".$pram." FROM ".$this->table." WHERE 1=1 ".$whr_clz;
	}

	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}
	
	public function UpdateStatus()
	{
		return "UPDATE ".$this->table." SET status = '".hlpMysqlRealScape($this->status)."'  xWHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
}

?>