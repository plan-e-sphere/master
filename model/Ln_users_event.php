<?php
class Ln_users_event extends Model{
	public $primaryKey = 'ln_users_events_id';
	
	public function isInvite($idEvent, $idUserInvite){
		$topInvite = $this->findCount("users_users_id = ".$idUserInvite." and events_events_id = ".$idEvent);
		if($topInvite==0){
			$retour = false;
		}else{
			$retour = true;
		}
		return $retour;	
	}
	
	public function getUsersAccepted($idEvent){
		$list = $this->find(array(
				'fields'     => 'User.*',
				'conditions' => array('Ln_users_event.events_events_id'=>$idEvent, 'Ln_users_event.ln_users_events_accepted'=>1), 
				'join'		 => array('users as User'=>' Ln_users_event.users_users_id=User.users_id'), 
				'order'		 => 'Ln_users_event.ln_users_events_date_reponse'
			));
		return $list;
	}
	
	public function getNbParticipants ($idEvent){
		$nbParticipants = $this->findCount("Ln_users_event.events_events_id=".$idEvent." and Ln_users_event.ln_users_events_accepted = 1");
		return $nbParticipants;
	}
	
	public function getUsersRefused($idEvent){
		$list = $this->find(array(
				'fields'     => 'User.*',
				'conditions' => array('Ln_users_event.events_events_id'=>$idEvent, 'Ln_users_event.ln_users_events_accepted'=>-1),
				'join'		 =>  array('users as User'=>' Ln_users_event.users_users_id=User.users_id'), 
			));
		return $list;
	}
	
	public function getUsersInvited($idEvent){
		$list = $this->find(array(
				'fields'     => 'User.*',
				'conditions' => array('Ln_users_event.events_events_id'=>$idEvent, 'Ln_users_event.ln_users_events_accepted'=>0),
				'join'		 =>  array('users as User'=>' Ln_users_event.users_users_id=User.users_id'), 
			));
		return $list;
	}
	
	public function getUsersMaybe($idEvent){
		$list = $this->find(array(
				'fields'     => 'User.*',
				'conditions' => array('Ln_users_event.events_events_id'=>$idEvent, 'Ln_users_event.ln_users_events_accepted'=>2),
				'join'		 =>  array('users as User'=>' Ln_users_event.users_users_id=User.users_id'), 
			));
		return $list;
	}
	
	public function getStatutUser($idEvent, $idUser){
		if($this->isInvite($idEvent, $idUser)){
			$statut=$this->findFirst(array(
				'fields'     => 'Ln_users_event.*',
				'conditions' => array('Ln_users_event.events_events_id'=>$idEvent,'Ln_users_event.users_users_id'=>$idUser),
			));
		}else{
			$statut_object=new StdClass();
			$statut_object->ln_users_events_accepted=0;
			$statut_object->ln_users_events_role="visiteur";
			$statut=$statut_object;
		}
		return $statut;		
	}
}