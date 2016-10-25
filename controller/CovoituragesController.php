<?php
class Covoiturage extends Controller{
	
	public function listeChauffeur($eventId){
		$this->loadModel('ln_users_covoiturage');
		$d['chauffeurs'] = $this->ln_users_covoiturage->getListChauffeurs($eventId);
		$this->set($d);
	}
}