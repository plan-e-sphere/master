<?php
class Fourniture extends Model{
	public $primaryKey = 'fournitures_id';
	
	public function deleteFourniture($id,$listeFournitures){
		$fournitures=$this->find(array(
				'fields'		=>'Fourniture.*',
				'conditions'	=>array('Fourniture.events_events_id'=>$id)));
		foreach ($fournitures as $k => $v):
			if(!in_array($v->fournitures_id,$listeFournitures)){
				$this->delete($v->fournitures_id);
			}
		endforeach;
	}
	
	function getQteFounitureRestante($idFourniture){
		$fournitures=$this->find(array(
				'fields'		=>'Fourniture.fournitures_quantite, Ln_users_fourniture.ln_users_fourniture_qte',
				'conditions'	=>array('Fourniture.fournitures_id'=>$idFourniture),
				'join'			=>array('ln_users_fournitures as Ln_users_fourniture'=>'Ln_users_fourniture.fournitures_fournitures_id = Fourniture.fournitures_id')
				)
			);
		$quantite_totale=$fournitures[0]->fournitures_quantite;
		$quantite_amenee=0;
		foreach($fournitures as $k=>$v){
			$quantite_amenee+=$v->ln_users_fourniture_qte;
		}
		$quantite_restante=$quantite_totale-$quantite_amenee;
		if($quantite_restante<0){
			$quantite_restante=0;
		}
		return $quantite_restante;
	}
	
	public function getFournitureById($idFourniture){
		$fourniture=$this->findFirst(array(
				'fields'		=>'Fourniture.*',
				'conditions'	=>array('Fourniture.fournitures_id'=>$idFourniture),
				)
			);
		return $fourniture;
	}
}