<?php
class Covoiturage extends Model{
	public $primaryKey = 'Covoiturages_id';
	
	function addCovoiturage($idEvent,$covoit){
		//debug($covoit);
		$covoiturage=new stdClass();
		$covoiturage->covoiturages_events_id = $idEvent;
		$covoiturage->covoiturages_nb_places_max = $covoit->nbPlaceMax;
		$covoiturage->covoiturages_lieu_rdv = $covoit->lieu;
		$covoiturage->covoiturages_datetime_rdv= $this->formatage($covoit->dateHeure);
		
		$this->save($covoiturage);
	}
	
	private function formatage($dateTime){
		$retour = "";
		$split1 = explode(" ",$dateTime);
		$split2 = explode("-",$split1[0]);
		$retour = $split2[2]."-".$split2[1]."-".$split2[0]." ".$split1[1];
		return $retour;
	
	}
	
	function removeCovoiturage($id){
		echo $id;
		$delete_covoit=$this->find(array(
					'fields'		=>'Covoiturage.*',
					'conditions'	=>array('Covoiturage.covoiturages_id'=>$id)));
		debug($delete_covoit);
			foreach ($delete_covoit as $k => $v):
					$this->delete($v->covoiturages_id);
					//debug($v);
			endforeach;
	}

	
}
