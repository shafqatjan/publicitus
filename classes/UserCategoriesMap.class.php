<?php


class UserCategoriesMap
{

	private $id;
	private $user_id;
	private $category_id;
	private $status;
	private $dated;

	public function __construct()
	{
		$this->id='';
		$this->user_id = '';
		$this->category_id = '';
		$this->status = '';
		$this->dated = '';
		
		$this->table = TBL_USER_EXPERTISE;
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
    if($this->user_id == '')
		$error .= '&nbsp;&bull;&nbsp;User Id cannot be left blank.<br>';
    if($category_id == '')
		$error .= '&nbsp;&bull;&nbsp;Category Id cannot be left blank.<br>';
    if($this->status == '')
		$error .= '&nbsp;&bull;&nbsp;Status cannot be left blank.<br>';
    if($this->dated == '')
		$error .= '&nbsp;&bull;&nbsp;Dated password cannot be left blank.<br>';
		return $error;
	}

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		user_id = '".hlpMysqlRealScape($this->user_id)."', 
		category_id = '".hlpMysqlRealScape($this->category_id)."';"; 
	}
	public function AddUserCat($valuesClause)
	{
	  return "INSERT INTO ".$this->table."(user_id , category_id) ".$valuesClause.";"; 
	}	

	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		category_id = '".hlpMysqlRealScape($this->category_id)."',
		dated = '".hlpMysqlRealScape($this->dated)."',
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
	
	 public function DeleteByUserId()
	 {
	  return "DELETE FROM ".$this->table." WHERE user_id = ".intval($this->user_id);
	 }	
	
	public function UpdateStatus()
	{
		return "UPDATE ".$this->table." SET 
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
	

}

?>