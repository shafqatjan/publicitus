<?php

class PakageApplication
{

	private $id; //int(11)
	private $pakage_id; //varchar(70)
	private $user_id; //varchar(70)	
	private $status;
	private $dated;
	private $agree;

	public function __construct()
	{
		$this->id='';
		$this->pakage_id= '';
		$this->user_id = '';
		$this->status = '1';
		$this->dated = '';
		$this->table = TBL_PAKAGE_APP;
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
		if($this->agree == '')
			$error .= '&nbsp;&bull;&nbsp;Pleaze Agree to Term And condition.<br>';
		if($this->pakage_id == '')
			$error .= '&nbsp;&bull;&nbsp;Pakages cannot be left blank.<br>';
		if($this->user_id == '')
			$error .= '&nbsp;&bull;&nbsp;User cannot be left blank.<br>';
			
		return $error;
	}


	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		pakage_id = '".hlpMysqlRealScape($this->pakage_id)."', 
		user_id = '".hlpMysqlRealScape($this->user_id)."',  
		status = '".hlpMysqlRealScape($this->status)."';";
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		pakage_id = '".hlpMysqlRealScape($this->pakage_id)."', 
		user_id = '".hlpMysqlRealScape($this->user_rate)."',  
		status = '".hlpMysqlRealScape($this->status)."
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