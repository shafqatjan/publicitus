<?php

class JobAppFile
{

	private $id; //int(11)
	private $file_type; //varchar(70)
	private $file_type_id; //varchar(70)	
	private $file_name;
	private $status;
	private $dated;

	public function __construct()
	{
		$this->id='';
		$this->file_type= '';
		$this->file_type_id = '';
		$this->file_name = '';
		$this->status = '';
		$this->dated = '';
		$this->table = TBL_APP_FILE;
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
		if($this->file_name == '')
			$error .= '&nbsp;&bull;&nbsp;Please select file.<br>';
		return $error;
	}


	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		file_type = '".hlpMysqlRealScape($this->file_type)."', 
		file_type_id = '".hlpMysqlRealScape($this->file_type_id)."', 
		file_name = '".hlpMysqlRealScape($this->file_name)."', 
		status = '".hlpMysqlRealScape($this->status)."';";
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		file_type = '".hlpMysqlRealScape($this->file_type)."', 
		file_type_id = '".hlpMysqlRealScape($this->file_type_id)."', 
		file_name = '".hlpMysqlRealScape($this->file_name)."', 
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