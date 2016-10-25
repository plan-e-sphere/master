<?php
class Groupe extends Model{
	public $primaryKey = 'groupes_id';
	
	public function getListGroupeByUser($user_id){
		$groupes=$this->find(array(
				'fields'		=>'Groupe.*',
				'conditions'	=>array('Ln_groupes_user.users_users_id'=>$user_id),
				'join'			=>array('ln_groupes_users as Ln_groupes_user'=>'Ln_groupes_user.groupes_groupes_id = Groupe.groupes_id')
				)
			);
		return $groupes;
	}
	
	public function getAllUsers($groupe_id){
		$users=$this->find(array(
				'fields'		=>'User.*',
				'conditions'	=>array('Groupe.groupes_id'=>$groupe_id),
				'join'			=>array('ln_groupes_users as Ln_groupes_user'=>'Ln_groupes_user.groupes_groupes_id = Groupe.groupes_id',
										'users as User' => 'Ln_groupes_user.users_users_id = User.users_id'
				)
		));
		
		return $users;
	}
	
	public function getMembre($groupe_id){
		$users_membres=$this->find(array(
				'fields'		=>'User.*',
				'conditions'	=>array('Groupe.groupes_id'=>$groupe_id,
										'Ln_groupes_user.ln_groupes_users_role'=>'Membre'),
				'join'			=>array('ln_groupes_users as Ln_groupes_user'=>'Ln_groupes_user.groupes_groupes_id = Groupe.groupes_id',
										'users as User' => 'Ln_groupes_user.users_users_id = User.users_id'
				)
		));
		
		return $users_membres;
	}
	
	public function getModo($groupe_id){
		$users_modos=$this->find(array(
				'fields'		=>'User.*',
				'conditions'	=>array('Groupe.groupes_id'=>$groupe_id,
										'Ln_groupes_user.ln_groupes_users_role'=>'Modo'),
				'join'			=>array('ln_groupes_users as Ln_groupes_user'=>'Ln_groupes_user.groupes_groupes_id = Groupe.groupes_id',
										'users as User' => 'Ln_groupes_user.users_users_id = User.users_id'
				)
		));
		
		return $users_modos;
	}
	
	public function getAdmin($groupe_id){
		$users_admins=$this->find(array(
				'fields'		=>'User.*',
				'conditions'	=>array('Groupe.groupes_id'=>$groupe_id,
										'Ln_groupes_user.ln_groupes_users_role'=>'Admin'),
				'join'			=>array('ln_groupes_users as Ln_groupes_user'=>'Ln_groupes_user.groupes_groupes_id = Groupe.groupes_id',
										'users as User' => 'Ln_groupes_user.users_users_id = User.users_id'
				)
		));
		
		return $users_admins;
	}
	
	public function getGroupeById($groupe_id){
		$groupe=$this->findFirst(array(
				'fields'		=>'Groupe.*',
				'conditions'	=>array('Groupe.groupes_id'=>$groupe_id),
		));
		
		$groupe->users_membres=$this->getMembre($groupe_id);
		$groupe->users_modos=$this->getModo($groupe_id);
		$groupe->users_admins=$this->getAdmin($groupe_id);
		
		return $groupe;
	}
	
	public function exist($groupe_id){
		if($this->findCount(array("groupes_id"=>$groupe_id))>0){
			$result=true;
		}else{
			$result=false;
		}
		return $result;
	}
}