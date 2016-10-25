<?php
class Ln_groupes_user extends Model{
	public $primaryKey = 'ln_groupes_users_id';
	
	public function isMembre($groupe_id, $user_id){
		$result=$this->findCount(array('users_users_id'=>$user_id, 'groupes_groupes_id'=>$groupe_id));
		if($result>0){
			$response=true;
		}else{
			$response=false;
		}
		return $response;
	}
	
	public function inviteGroupe($user_id, $groupe_id){
		$invitation=new stdClass();
		$invitation->groupes_groupes_id=$groupe_id;
		$invitation->users_users_id=$user_id;
		$invitation->ln_groupes_users_role="Membre";
		
		$this->save($invitation);
	}
	
	public function getRole($user_id, $groupe_id){
		$role=$this->findFirst(array(
				'fields'		=>'Ln_groupes_user.ln_groupes_users_role',
				'conditions'	=>array('Ln_groupes_user.groupes_groupes_id'=>$groupe_id,
										'Ln_groupes_user.users_users_id'=>$user_id),
		));
		if($role==null){
			$role="Visiteur";
		}else{
			$role=$role->ln_groupes_users_role;
		}
		return $role;
	}
	
	//Supprime toutes les lignes en rapport avec un groupe
	function deleteAllByGroupe($groupe_id){
		$this->deleteAll('groupes_groupes_id='.$groupe_id);
	}
	
	function updateRole($role, $user_id, $groupe_id){
		$user=$this->findFirst(array(
				'fields'		=>'Ln_groupes_user.*',
				'conditions'	=>array('Ln_groupes_user.groupes_groupes_id'=>$groupe_id,
										'Ln_groupes_user.users_users_id'=>$user_id),
		));
		$user->ln_groupes_users_role=$role;
		$this->save($user);
	}
	
	function deleteUserFromGroupe($user_id, $groupe_id){
		$this->deleteAll(array('conditions'	=>array('groupes_groupes_id'=>$groupe_id,
										'users_users_id'=>$user_id)));
	}
}