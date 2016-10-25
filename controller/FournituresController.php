<?php 
class FournituresController extends Controller{
	
	function ajoutFourniture($id_fourniture, $id_user, $quantite=0){
		$this->loadModel('Ln_users_fourniture');
		$users_founitures['fournitures_fournitures_id']=$id_fourniture;
		$users_founitures['users_users_id']=$id_user;
		$users_founitures['ln_users_fourniture_qte']=$quantite;
		if($this->Ln_users_fourniture->findCount(array('fournitures_fournitures_id'=>$id_fourniture, 'users_users_id'=>$id_user))<1){
			$this->Ln_users_fourniture->save($users_founitures);
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function supFourniture($id){
		$this->loadModel('Ln_users_fourniture');
		$this->Ln_users_fourniture->delete($id);
	}
	
	function updateQuantite($id,$quantite, $idFourniture){
		$this->loadModel('Ln_users_fourniture');
		$users_founitures['ln_users_fournitures_id']=$id;
		$users_founitures['ln_users_fourniture_qte']=$quantite;
		$this->Ln_users_fourniture->save($users_founitures);
	}
	
	function updateDetail($id, $detail, $idFourniture){
		$this->loadModel('Ln_users_fourniture');
		$users_founitures['ln_users_fournitures_id']=$id;
		$users_founitures['ln_users_fourniture_detail']=$detail;
		$this->Ln_users_fourniture->save($users_founitures);
	}
	
	function getQteFounitureRestante($idFourniture){ 
		$this->loadModel('Fourniture');
		echo $this->Fourniture->getQteFounitureRestante($idFourniture); 
	}
	
	function listFournitureUser($id_event, $id_user){
		$this->loadModel('Fourniture');
		$this->loadModel('Ln_users_fourniture');
		$listeFournitures=$this->Ln_users_fourniture->find(array(
				'fields'     => 'Ln_users_fourniture.*, Fourniture.*',
				'conditions' => array('Ln_users_fourniture.users_users_id'=>$id_user,
										'Fourniture.events_events_id'=>$id_event),
				'join'		 =>  array('fournitures as Fourniture'=>' Fourniture.fournitures_id=Ln_users_fourniture.fournitures_fournitures_id'), 
			)
		);
		$i=0;
		$buffer='<table>
		<tr>
			<th class="tdFourniture"></th>
			<th class="tdFourniture">Libelle</th>
			<th class="tdFourniture">Quantité apportée</th>
			<th class="tdFourniture">Détails</th>
		</tr>';
		foreach($listeFournitures as $k=>$v){
			$buffer.='<tr class="trFourniture"><td class="tdFourniture">';
			$buffer.='<a onclick="sup_fourniture('.$v->ln_users_fournitures_id.','.$v->fournitures_id.')"><img src="'.IMG.'/refuse.png" class="icone_btn"/></a> ';
			$buffer.='<a onclick="modalUpdate('.$v->fournitures_id.','.$v->users_users_id.')" data-toggle="modal" data-target="#fournitureUpdate"><img src="'.IMG.'/update.png" class="icone_btn"/></a>';
			$buffer.='</td>';
			$buffer.='<td class="tdFourniture">';
			$buffer.=$v->fournitures_libelle;
			$buffer.='</td>';
			$buffer.='<td class="tdFourniture">';
			$buffer.=$v->ln_users_fourniture_qte;
			$buffer.=$v->fournitures_unite;
			$buffer.='</td>';
			$buffer.='<td>';
			$buffer.=$v->ln_users_fourniture_detail;
			$buffer.='</td>';
			$buffer.='</tr>';
			$i++;
		}
		$buffer.='</table>';
		echo $buffer;
	}
	
	function listUsersQteFourniture($idFourniture){
		$this->loadModel('Ln_users_fourniture');
		$this->loadModel('Fourniture');
		$fourniture=$this->Fourniture->getFournitureById($idFourniture);
		$list=$this->Ln_users_fourniture->getUsersByFourniture($idFourniture);
		$buffer="<center>$fourniture->fournitures_libelle</center><br/>";
		$nb_qte_totale=0;
		if(count($list)>0){
			foreach($list as $k=>$v){
				if($v->ln_users_fourniture_qte>0){
					$buffer.="<img src='".$v->users_photo."' class='photo_arrondie_petite'/> ".$v->users_pseudo." ".$v->ln_users_fourniture_qte." ".$v->fournitures_unite." ".$v->ln_users_fourniture_detail."<br/>";
					$nb_qte_totale+=$v->ln_users_fourniture_qte;
				}
			}
		}else{
			$buffer.="<span class='red'>Personne n'a encore pris en charge cette fourniture</span><br/>";
		}
		$buffer.="<br/>Quantite totale apportée :".$nb_qte_totale." ".$fourniture->fournitures_unite;
		echo $buffer;
	}
	
	function formUpdateFourniture($idFourniture, $idUser){
		$this->loadModel('Fourniture');
		$this->loadModel('Ln_users_fourniture');
		$fournitures=$this->Ln_users_fourniture->findFirst(array(
				'fields'     => 'Ln_users_fourniture.*, Fourniture.*',
				'conditions' => array('Ln_users_fourniture.users_users_id'=>$idUser,
										'Ln_users_fourniture.fournitures_fournitures_id'=>$idFourniture
										),
				'join'		 =>  array('fournitures as Fourniture'=>' Fourniture.fournitures_id=Ln_users_fourniture.fournitures_fournitures_id'), 
			)
		);
		if($fournitures->ln_users_fourniture_detail=="-"){
			$detail="";
		}else{
			$detail=$fournitures->ln_users_fourniture_detail;
		}
		$buffer='<table><tr><td>';
		$buffer.='Quantité :</td><td><input id="inputQte" value="'.$fournitures->ln_users_fourniture_qte.'" onblur="updateQte('.$fournitures->ln_users_fournitures_id.',\'inputQte\','.$fournitures->fournitures_id.');"/>'.$fournitures->fournitures_unite.'<br/>';
		$buffer.='</td></tr><tr><td>';
		$buffer.='Détail :</td><td><textarea id="inputDetail" onblur="updateDetail('.$fournitures->ln_users_fournitures_id.',\'inputDetail\','.$fournitures->fournitures_id.');">'.$detail.'</textarea>';
		$buffer.='</td></tr></table>';
		echo $buffer;
	}
}
   
  