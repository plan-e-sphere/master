<?php 
class GroupesController extends Controller{
	
	/**
	* Blog, liste les articles
	**/
	function index(){
		if($this->Session->isLogged()){
			$this->loadModel('Groupe'); 
			$d['listeGroupes'] = $this->Groupe->getListGroupeByUser($this->Session->User("users_id"));
			$d['title']="Mes Sphères";
			$this->set($d);
			$this->render('index');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexions');
		}
	}

	/**
	* formulaire d'ajout
	**/
	function newGroupe(){
		if($this->Session->isLogged()){
			$this->loadModel('Groupe'); 
			$d['listeGroupes'] = $this->Groupe->getListGroupeByUser($this->Session->User("users_id"));
			$this->set($d);
			$this->render('newGroupe');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	/*
	* inviter un ami à un events	
	**/
	function inviteGroupe($idFriend,$idGroupe){
		if($this->Session->isLogged()){
			$this->loadModel('Ln_groupes_user');
			$this->loadModel('Notification');
			if($this->Ln_groupes_user->getRole($this->Session->User('users_id'),$idGroupe)!="Visiteur"){
				$this->Ln_groupes_user->inviteGroupe($idFriend, $idGroupe);
				$this->Notification->createNotif($this->Session->User('users_id'), $idFriend, $idGroupe, "invite_groupe");
			}
		}		
	}
	/**
	* affiche un evenement
	**/
	function view($id=null,$update=null){
		if($this->Session->isLogged()){
			$this->loadModel('Groupe');
			if($id!=null and $this->Groupe->exist($id)){
				$this->loadModel('User');
				$this->loadModel('Ln_groupes_user');
				
				//Récupération des infos du groupe
				$groupe=$this->Groupe->getGroupeById($id);
				$groupe->role=$this->Ln_groupes_user->getRole($this->Session->User("users_id"),$id);
				$d['groupes'] = $groupe;
				
				//Récupération de la liste d'ami
				$param=$this->User->getFriendsListe($this->Session->User("users_id"));
				foreach ($param as $k=>$v){
					if($this->Ln_groupes_user->isMembre($id,$v->users_id)==true){
						$v->invit=true;
					}else{
						$v->invit=false;
					}	
					
				}
				
				//recuperation liste des groupes pour le menu
				$list_groupes=$this->Groupe->getListGroupeByUser($this->Session->User("users_id"));
				$d['listeGroupes']=$list_groupes;
				
				$d['friendsList']= $param;
				$this->set($d);
				$this->render('view');
			}else{
				$this->e404("Le groupe que vous recherchez n'existe pas ou a été supprimé");
			}
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
	
	/**
	* Ajout un evenement
	**/
	function add(){
		$this->loadModel('Groupe'); 
		$this->loadModel('Ln_groupes_user');
		if($this->request->data){
			$this->Groupe->save($this->request->data);
			if(isset($this->request->data->groupes_id)){
				$this->Session->setFlash('Le contenu a bien été modifié'); 
				$this->redirect('groupes/view/'.$this->request->data->groupes_id);
			}else{
				$ln_groupes_users=new stdClass();
				$ln_groupes_users->users_users_id=$this->Session->User("users_id");
				$ln_groupes_users->groupes_groupes_id=$this->Groupe->id;
				$ln_groupes_users->ln_groupes_users_role='Admin';
				$this->Ln_groupes_user->save($ln_groupes_users);
				$this->Session->setFlash('Le contenu a bien été ajouté'); 
				$this->redirect('groupes/index'); 
			}
		}else{
			$this->Session->setFlash('Merci de corriger vos informations','error'); 
		}
	}
	
	/**
	* acceptation / refus de l'events
	**/
	function acceptRefuse($eventID,$choix){

		$this->loadModel('Ln_users_event');
		$this->loadModel('User');
		
		$accept=array("ln_users_events_id"=>$eventID,
					"ln_users_events_accepted"=>$choix);
		$this->Ln_users_event->save($accept);
		echo $choix;
	}
	
	/**
	* Supprime un evenement
	**/
	function delete($id){
		if($this->Session->isLogged()){
			$this->loadModel('Groupe'); 
			$this->loadModel('Ln_groupes_user');
			$this->loadModel('Notification');
			if($this->Ln_groupes_user->getRole($this->Session->User('users_id'), $id)=="Admin"){
				$this->Ln_groupes_user->deleteAllByGroupe($id);
				$this->Groupe->delete($id);
				$this->Session->setFlash('Le groupe a bien ete supprime'); 
				$this->redirect('groupes/index'); 
			}else{
				foreach($this->Groupe->getAdmin($id) as $admin){
					$this->Notification->createNotif($this->Session->User('users_id'), $admin->users_id, $id, "alerte_sup_groupe");
				}
				$this->Session->setFlash('Vous n\'êtes pas habilité à supprimer ce groupe, les administrateurs du groupe ont été prévenus de votre action');
				$this->redirect('groupes/view/'.$id); 
			}
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
	function promouvoir($role, $user_id, $groupe_id){
		$this->loadModel('Ln_groupes_user');
		$this->loadModel('Notification');
		if($this->Ln_groupes_user->getRole($this->Session->User('users_id'), $groupe_id)=="Admin"){
			$this->Ln_groupes_user->updateRole($role, $user_id, $groupe_id);
			$this->Notification->createNotif($this->Session->User('users_id'), $user_id, $groupe_id, "promotion_groupe_".$role);
		}
	}
	
	function exclure($user_id, $groupe_id){
		$this->loadModel('Ln_groupes_user');
		$this->loadModel('Notification');
		if($this->Ln_groupes_user->getRole($this->Session->User('users_id'), $groupe_id)=="Admin"){
			$this->Ln_groupes_user->deleteUserFromGroupe($user_id, $groupe_id);
			$this->Notification->createNotif($this->Session->User('users_id'), $user_id, $groupe_id, "exclusion_groupe");
		}
	}
	
	function quitter($user_id, $groupe_id){
		$this->loadModel('Ln_groupes_user');
		$this->loadModel('Notification');
		if($this->Session->User('users_id') == $user_id){
			$this->Ln_groupes_user->deleteUserFromGroupe($user_id, $groupe_id);
		}
		echo "Vous avez bien quitté le groupe";
	}
	
	function ajax($function, $groupe_id=null){
		switch ($function){
			case "administrateur" :
				$this->loadModel('Groupe');
				$this->loadModel('Ln_groupes_user');
				$administrateurs=$this->Groupe->getAdmin($groupe_id);
				foreach ($administrateurs as $k => $v){
					echo '<h4><img src="'.$v->users_photo.'" class="photo_arrondie_petite"/> '.$v->users_pseudo.'</h4>';
				}
			break;
			case "moderateur" :
				$this->loadModel('Groupe');
				$this->loadModel('Ln_groupes_user');
				$moderateur=$this->Groupe->getModo($groupe_id);
				$html="";
				foreach ($moderateur as $k => $v){
					$html.='<h4>';
					$html.='<img src="'.$v->users_photo.'" class="photo_arrondie_petite"/> '.$v->users_pseudo;
					if($this->Ln_groupes_user->getRole($this->Session->User('users_id'), $groupe_id)=="Admin"){
						$html.=' <button id="btn_promotion'.$v->users_id.'" class="button_perso" onclick="promouvoir(\'Admin\','.$v->users_id.','.$groupe_id.');">Promotion</button>';
						$html.=' <button class="button_perso" onclick="exclure('.$v->users_id.','.$groupe_id.');">Exclure</button>';
					}
					$html.='</h4>';
				}
				echo $html;
			break;
			case "membre" :
				$this->loadModel('Groupe');
				$this->loadModel('Ln_groupes_user');
				$membre=$this->Groupe->getMembre($groupe_id);
				$html="";
				foreach ($membre as $k => $v){
					$html.='<h4>';
					$html.='<img src="'.$v->users_photo.'" class="photo_arrondie_petite"/> '.$v->users_pseudo;
					if($this->Ln_groupes_user->getRole($this->Session->User('users_id'), $groupe_id)=="Admin"){
						$html.=' <button id="btn_promotion'.$v->users_id.'" class="button_perso" onclick="promouvoir(\'Modo\','.$v->users_id.','.$groupe_id.');">Promotion</button>';
						$html.=' <button class="button_perso" onclick="exclure('.$v->users_id.','.$groupe_id.');">Exclure</button>';
					}
					$html.='</h4>';
				}
				echo $html;
			break;
		}
	}
}
