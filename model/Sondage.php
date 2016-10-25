<?php
class Sondage extends Model{
	public $primaryKey = 'sondages_id';
	
        function getSondagesByEvent($events_id){
            $sondage=$this->find(array(
				'fields'     => 'Sondage.*',
				'conditions' => array('Sondage.sondages_events_id'=>$events_id),
			));
            return $sondage;
        }
	
	/*function getSondagesByLibelle($id_user, $libelle){
		$adresse=$this->findFirst(array(
				'fields'     => 'Adresse.*',
				'conditions' => array('Adresse.adresses_users_id'=>$id_user,'Adresse.adresses_libelle'=>$libelle),
			));
		$adresse_string=$adresse->adresses_num_voie." ".$adresse->adresses_voie." ".$adresse->adresses_cp." ".$adresse->adresses_ville." ".$adresse->adresses_pays;
		return $adresse_string;
	}
	
	function getAdresseByUser($id_user){
		$adresse=$this->find(array(
				'fields'     => 'Adresse.*',
				'conditions' => array('Adresse.adresses_users_id'=>$id_user),
			));
		return $adresse;
	}
	
	function getAdresseById($id){
		$adresse=$this->findFirst(array(
				'fields'     => 'Adresse.*',
				'conditions' => array('Adresse.adresses_id'=>$id),
			));
                return $adresse;
	}*/
}