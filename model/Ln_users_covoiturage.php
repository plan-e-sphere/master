<?php
class Ln_users_covoiturage extends Model{
	public $primaryKey = 'Ln_users_covoiturage_id';
	
	function addPassager($idEvent, $idPassager, $isConducteur,$idCovoit){
		$ln_users_covoiturages = new stdClass();
		$ln_users_covoiturages->ln_users_covoiturage_event_id = $idEvent;
		$ln_users_covoiturages->ln_users_covoiturage_users = $idPassager;
		$ln_users_covoiturages->ln_users_covoiturage_covoiturage_id = $idCovoit;
		$ln_users_covoiturages->ln_users_covoiturage_conducteur = $isConducteur;
		
		$this->save ($ln_users_covoiturages);
			 
	}
	
	function removePassager($eventId, $userId){
		$isChauffeur=$this->getTripStatut($userId, $eventId);
		if($isChauffeur=="chauffeur"){
			$id_covoit=$this->getCovoit($userId,$eventId);
			$user_covoit=$this->find(array(
					'fields'		=>'Ln_users_covoiturage.*',
					'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$eventId,"Ln_users_covoiturage.ln_users_covoiturage_covoiturage_id"=>$id_covoit)));
			foreach ($user_covoit as $k => $v):
					$this->delete($v->ln_users_covoiturage_id);
					//debug($v);
			endforeach;
			
		}else{
			$user_covoit=$this->find(array(
					'fields'		=>'Ln_users_covoiturage.*',
					'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$eventId,'Ln_users_covoiturage.ln_users_covoiturage_users'=>$userId)));
			foreach ($user_covoit as $k => $v):
					$this->delete($v->ln_users_covoiturage_id);
					//debug($v);
			endforeach;
		}
		return $user_covoit;
	}
	
	function getCovoitChoice($eventId,$userId){
		$retour="";
		$isChauffeur=$this->getTripStatut($userId, $eventId);
		//debug($isChauffeur);
		if($this->getTripStatut($userId, $eventId)=="chauffeur" || $this->getTripStatut($userId, $eventId)=="passager" ){
			$chauffeur=$this->getChauffeur($userId, $eventId);
			//debug($chauffeur);
			$idCovoit = $this->getIDlnUserCovoit($eventId,$chauffeur->users_id);
			$retour = $this->getListPassager($idCovoit);
		}
		
		else if ($this->getTripStatut($userId, $eventId)=="visiteur"){
			$retour = $this->getListChauffeurs($eventId);
		}
		return $retour;
	}	
	function getIDlnUserCovoit($idEvent,$idChauffeur){
		$id=$this->findFirst(array(
				'fields'		=>'Ln_users_covoiturage.ln_users_covoiturage_covoiturage_id',
				'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$idEvent,'Ln_users_covoiturage.ln_users_covoiturage_users'=>$idChauffeur,'Ln_users_covoiturage.ln_users_covoiturage_conducteur'=>1),
				)
			);
		return $id->ln_users_covoiturage_covoiturage_id;
	}
	function getListPassager($ln_users_covoiturage_covoiturage_id){
		$listPassagers=$this->find(array(
				'fields'		=>'User.*',
				'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_covoiturage_id'=>$ln_users_covoiturage_covoiturage_id),
				'join'			=>array('users as User'=>'User.users_id=Ln_users_covoiturage.ln_users_covoiturage_users'),
				)
			);
		return $listPassagers;
	}
	
	function getListChauffeurs($event_id){
		$chauffeurs=$this->find(array(
				'fields'		=>'User.*',
				'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$event_id,'Ln_users_covoiturage.ln_users_covoiturage_conducteur'=>1, ),
				'join'			=>array('users as User'=>'User.users_id=Ln_users_covoiturage.ln_users_covoiturage_users'),
				));
		return $chauffeurs;
	}
	
	function getChauffeur($user_id, $event_id){
		$chauffeur=$this->findFirst(array(
				'fields'		=>'User.*, Ln_users_covoiturage.*',
				'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$event_id,'Ln_users_covoiturage.ln_users_covoiturage_conducteur'=>1 ),
				'join'			=>array('users as User'=>'User.users_id=Ln_users_covoiturage.ln_users_covoiturage_users')
				));
		return $chauffeur;
	}
	
	function getTripStatut($user_id, $event_id){
		$retour="visiteur";
		$result=$this->	findFirst(array(
				'fields'		=>'Ln_users_covoiturage.ln_users_covoiturage_conducteur',
				'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$event_id,'Ln_users_covoiturage.ln_users_covoiturage_users'=>$user_id),
				));
		//debug($result);
		if($result!=""){
			if($result->ln_users_covoiturage_conducteur==0){
				$retour="passager";
			}elseif($result->ln_users_covoiturage_conducteur==1){
				$retour="chauffeur";
			}else{
				$retour="visiteur";
			}
		}
		return $retour;
	}
	
	function getCovoit($userChauffeur_id, $event_id){
		$covoitId=$this->findFirst(array(
				'fields'		=>'Ln_users_covoiturage.ln_users_covoiturage_covoiturage_id',
				'conditions'	=>array('Ln_users_covoiturage.ln_users_covoiturage_users'=>$userChauffeur_id,'Ln_users_covoiturage.ln_users_covoiturage_event_id'=>$event_id,'Ln_users_covoiturage.ln_users_covoiturage_conducteur'=>1 ),
				));
		//echo "***".$covoitId->ln_users_covoiturage_covoiturage_id;
		return $covoitId->ln_users_covoiturage_covoiturage_id;
	
		
	}
}
