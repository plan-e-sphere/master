<?php
class Adresse extends Model{
	public $primaryKey = 'adresses_id';
	
	function getAdresseByLibelle($id_user, $libelle){
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
	}
}