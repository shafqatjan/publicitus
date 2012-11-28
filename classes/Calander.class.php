<?php

class calander
{

	private $id; //int(11)
	private $user_id;
	private $title; //varchar(255)
	private $description; //text
	private $dated; //datetime
	private $status; //int(11)
	private $table;
	public function __construct()
	{
		$this->user_id='';
		$this->title = '';
		$this->description = '';
		$this->dated = '';
		$this->status = '';
		$this->table = TBL_CALLANDER;
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


	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		user_id = '".hlpMysqlRealScape($this->user_id)."', 		
		title = '".hlpMysqlRealScape($this->title)."', 
		description = '".hlpMysqlRealScape($this->description)."', 
		status = '".hlpMysqlRealScape($this->status)."';";
	}

	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		user_id = '".hlpMysqlRealScape($this->user_id)."', 				
		title = '".hlpMysqlRealScape($this->title)."', 
		description = '".hlpMysqlRealScape($this->description)."'		WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($params = '*', $whr_clz='')
	{
		return "SELECT * FROM ".$this->table." WHERE 1=1 ".$whr_clz;
	}

	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}

}

?>