<?php

class MediaType
{

	private $id; //int(11)
	private $title; //varchar(255)
	private $status;
	private $dated;
	private $table;

	public function __construct()
	{
		$this->title = '';
		$this->status = '';
		$this->dated = '';
		$this->table = TBL_MEDIATYPE;
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
		$error = '';
		if(!$this->title)
			$error .= '&nbsp;&bull;&nbsp;Title cannot be left blank.<br />';
		return $error;
	}	

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		title = '".hlpMysqlRealScape($this->title)."', 
		status = '".hlpMysqlRealScape($this->status)."';";
	}

	public function Update()
	{
		return "UPDATE ".$this->table." SET 
	    title = '".hlpMysqlRealScape($this->title)."', 
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($params = '*', $whr_clz='')
	{
		return 'SELECT '.$params.' FROM '.$this->table.' WHERE 1=1 '.$whr_clz;
	}

	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}
	public function statusUpdate()
	{
		return "UPDATE ".$this->table." SET 
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}	
}

?>