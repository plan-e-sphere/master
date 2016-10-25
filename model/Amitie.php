<?php
class Amitie extends Model{
	public $primaryKey = 'amities_id';
	
	function isFriend($id, $id_principal){
		//pas ami
		if($this->findCount('amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$id_principal.'\'')<1 &&
			$this->findCount('amities_users_principal=\''.$id_principal.'\' and amities_users_secondaire=\''.$id.'\'')<1 &&
			$id!=$id_principal){
			return 0;
		//accepter la demande
		}elseif($this->findCount('amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$id_principal.'\' and amities_validation=0')>0){
			return 2;
		//en attente dacceptation
		}elseif($this->findCount('amities_users_principal=\''.$id_principal.'\' and amities_users_secondaire=\''.$id.'\' and amities_validation=0')>0){
			return 3;
		//ami
		}elseif($this->findCount('((amities_users_principal=\''.$id_principal.'\' and amities_users_secondaire=\''.$id.'\') or (amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$id_principal.'\'))
		and amities_validation=1')>0){
			return 1;
		//mon profil
		}elseif($id==$id_principal){
			return 4;
		}
	}
}