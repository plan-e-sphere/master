<?php
class Ln_users_fourniture extends Model{
	public $primaryKey = 'ln_users_fournitures_id';
	
	function getUsersByFourniture($idFourniture){
		$list=$this->find(array(
			"fields"		=>"Ln_users_fourniture.*, User.*, Fourniture.*",
			"conditions"	=>"Ln_users_fourniture.fournitures_fournitures_id=".$idFourniture,
			"join"			=>array("users as User"=>"User.users_id=Ln_users_fourniture.users_users_id",
									"fournitures as Fourniture"=>"Fourniture.fournitures_id=Ln_users_fourniture.fournitures_fournitures_id")));
		return $list;
	}
}