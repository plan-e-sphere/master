<?php 
class UsersController extends Controller{
	
   function index(){
		if($this->Session->isLogged()){
			$this->loadModel('User'); 
			$d['users']=$this->User->getFriendsListe($this->Session->User("users_id"));
			$this->set($d);
			$this->render('index');
		}else{
			$this->redirect('connexions/index');
		}
	}
   
  /**
	* Ajouter un user
	**/
	function add($update=null){
		$this->loadModel('User'); 
		if($this->request->data){
			if($update==null){
				$data = $this->request->data;
				$data->users_password = sha1($data->users_password);
				unset($this->request->data->users_password_verif);
                                if(empty($this->request->data->users_pseudo)){
                                    $pseudo=$this->request->data->users_prenom." ".$this->request->data->users_nom;
                                }else{
                                    $pseudo=$this->request->data->users_pseudo;
                                }
				$tab_users=array("users_pseudo"=>$pseudo,
								"users_nom"=>$this->request->data->users_nom,
								"users_prenom"=>$this->request->data->users_prenom,
								"users_mail"=>$this->request->data->users_mail,
								"users_login"=>$this->request->data->users_mail,
								"users_password"=>$this->request->data->users_password,
								"users_photo"=>"http://www.google.fr/url?source=imglanding&ct=img&q=https://www.latoilescoute.net/IMG/jpg/facebook-storm-trooper.jpg&sa=X&ei=EahRVe-4CIr8UqmkgNgC&ved=0CAkQ8wc&usg=AFQjCNG9Jk_ILdJs_gfdePmbLeWYq1qgMg");
				if(!$this->User->exist($tab_users['users_login'])){
					$this->User->save($tab_users);
					if(isset($this->request->data->users_id)){
						$this->Session->setFlash('Bienvenue Plan-e-Sphere'); 
						$this->redirect('users/profile/'.$this->request->data->users_id);
					}else{
						$this->Session->setFlash('Bienvenue sur Plan-e-Sphere!!!'); 
                                                $user=$this->User->findFirst(array(
                                                    'conditions' => array('users_id' => $this->User->id
                                                )));
						if(!empty($user)){
							$this->Session->write('User',$user); 
						}
						$this->request->data->users_password = ''; 
						if($this->Session->isLogged()){
							$this->redirect('events/index');
						}else{
							$this->render('login');
						}
						$this->redirect('events/index'); 
					}
				}else{
					$this->Session->setFlash('L\'adresse mail est déja utilisée merci de corriger vos informations','error'); 
					$this->redirect('connexion'); 
				}
			}else{
				if($this->request->data){
					$data = $this->request->data;
					$tab_users=array("users_id"=>$this->request->data->users_id,
									"users_pseudo"=>$this->request->data->users_pseudo,
									"users_nom"=>$this->request->data->users_nom,
									"users_prenom"=>$this->request->data->users_prenom,
									"users_mail"=>$this->request->data->users_mail,
									"users_photo"=>$this->request->data->users_photo);
						$this->User->save($tab_users);
						$user=$this->User->findFirst(array(
				'conditions' => array('users_id' => $this->request->data->users_id
			)));
						$this->Session->write('User',$user); 
						$this->Session->setFlash('Votre profil a bien été modifié'); 
						$this->redirect('users/profil/'.$this->request->data->users_id);
				}
			}
		}else{
			$this->Session->setFlash('Merci de corriger vos informations','error'); 
		}
	}
   
	/**
	* Login
	**/
	function login(){
		if($this->request->data){
			$data = $this->request->data;
			$data->users_password = sha1($data->users_password); 
			$this->loadModel('User'); 
			$this->loadModel('Notification'); 
			$user = $this->User->findFirst(array(
				'conditions' => array('users_login' => $data->users_mail,'users_password' => $data->users_password
			)));
			if(!empty($user)){
				$this->Session->write('User',$user); 
			}		
		}
		if($this->Session->isLogged()){
			$this->redirect('events/index');
		}else{
			$this->render('login');
		}
	}
	
	/**
	* Profil
	**/
	function profil($id,$update=null){
		if($this->Session->isLogged()){
			$this->loadModel('User'); 
			$this->loadModel('Amitie');
			$d['users'] = $this->User->findFirst(array(
				'conditions' => array('users_id' => $id
			)));
			$d['users']=array("users_id"=>$d['users']->users_id,
			"users_nom"=>$d['users']->users_nom,
			"users_prenom"=>$d['users']->users_prenom,
			"users_pseudo"=>$d['users']->users_pseudo,
			"users_photo"=>$d['users']->users_photo,
			"users_mail"=>$d['users']->users_mail,
			"users_amitie"=>$this->Amitie->isFriend($d['users']->users_id,$this->Session->user('users_id')));
			$this->set($d);
			if($update!=null){
				$this->render('updateProfil');
			}else{
				$this->render('profil');
			}
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
        /**
	* Profil
	**/
	function monProfil($update=null){
		if($this->Session->isLogged()){
			$this->loadModel('User'); 
			$this->loadModel('Amitie');
			$d['users'] = $this->User->findFirst(array(
				'conditions' => array('users_id' => $this->Session->User("users_id")
			)));
			$d['users']=array("users_id"=>$d['users']->users_id,
			"users_nom"=>$d['users']->users_nom,
			"users_prenom"=>$d['users']->users_prenom,
			"users_pseudo"=>$d['users']->users_pseudo,
			"users_photo"=>$d['users']->users_photo,
			"users_mail"=>$d['users']->users_mail,
			);
			$this->set($d);
			if($update!=null){
				$this->render('updateProfil');
			}else{
				$this->render('monProfil');
			}
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
        
	/**
	* Edit Profil
	**/
	function updateProfil($id){
		if($this->Session->isLogged()){
			$this->loadModel('User'); 
			$this->loadModel('Amitie');
			$d['users'] = $this->User->findFirst(array(
				'conditions' => array('users_id' => $id
			)));
			$d['users']=array("users_id"=>$d['users']->users_id,
			"users_nom"=>$d['users']->users_nom,
			"users_prenom"=>$d['users']->users_prenom,
			"users_pseudo"=>$d['users']->users_pseudo,
			"users_photo"=>$d['users']->users_photo,
			"users_mail"=>$d['users']->users_mail,
			"users_amitie"=>$this->Amitie->isFriend($d['users']->users_id,$this->Session->user('users_id')),);
			$this->set($d);
			$this->render('profil');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
	/**
	* AskFriends
	**/
	function askFriend($id,$method){
		if($this->Session->isLogged()){
			$this->loadModel('User'); 
			$this->loadModel('Amitie'); 
			$this->loadModel('Notification'); 
			switch ($method){
				case 0://Demande d'ami
					if( $this->User->findCount('users_id=\''.$id.'\'')>0 && 
							$this->Amitie->findCount('amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\'')<1 &&
							$this->Amitie->findCount('amities_users_principal=\''.$this->Session->user('users_id').'\' and amities_users_secondaire=\''.$id.'\'')<1 &&
							$id!=$this->Session->user('users_id')){
						
						$tab_amities=array("amities_users_principal"=>$this->Session->user('users_id'),
									"amities_users_secondaire"=>$id,
									"amities_validation"=>0);
						$this->Amitie->save($tab_amities);
						
						$tab_notification=array("notifications_users_id"=>$id,
										"notifications_users_emetteur_id"=>$this->Session->user('users_id'),
										"notifications_type"=>"demande_ami",
										"notifications_lu"=>0);
						$this->Notification->save($tab_notification);
						echo "0";
					}else{
						echo "-1";
					}
				break;
				case 1://Accepter ami
					if($this->Amitie->findCount('amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\'')>0 && $id!=$this->Session->user('users_id')){
						$amitie=$this->Amitie->findFirst(array(
								'conditions' => '(amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\')'
							)
						);
						$tab_amities=array("amities_id"=>$amitie->amities_id,
									"amities_validation"=>1);
						$this->Amitie->save($tab_amities);
						
						$tab_notification=array("notifications_users_id"=>$id,
										"notifications_users_emetteur_id"=>$this->Session->user('users_id'),
										"notifications_type"=>"accepter_ami",
										"notifications_lu"=>0);
						$this->Notification->save($tab_notification);
						
						echo "1";
					}else{
						echo "-1";
					}	
				break;
				case 2://Annuler invitation
					if($this->Amitie->findCount('amities_users_principal=\''.$this->Session->user('users_id').'\' and amities_users_secondaire=\''.$id.'\'')>0 && $id!=$this->Session->user('users_id')){
						$amitie=$this->Amitie->findFirst(array(
								'conditions' => '(amities_users_principal=\''.$this->Session->user('users_id').'\' and amities_users_secondaire=\''.$id.'\')'
							)
						);
						$nb_notif=$this->Notification->findCount("notifications_users_id=".$id." and notifications_users_emetteur_id=".$this->Session->user('users_id')." and notifications_type='demande_ami'");
						if($nb_notif>0){
							$notification=$this->Notification->findFirst(array(
								'conditions' => '(notifications_users_id='.$id.' and notifications_users_emetteur_id='.$this->Session->user("users_id").' and notifications_type=\'demande_ami\')'));
							$this->Notification->delete($notification->notifications_id);
						}
						$this->Amitie->delete($amitie->amities_id);
						echo "2";
					}else{
						echo "-1";
					}	
				break;
				case 3://Refuser ami
					if($this->Amitie->findCount('amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\' and amities_validation=0')>0 && 
							$id!=$this->Session->user('users_id')){
						$amitie=$this->Amitie->findFirst(array(
								'conditions' => '(amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\' and amities_validation=0)'
							)
						);
						$this->Amitie->delete($amitie->amities_id);
						echo "3";
					}else{
						echo "-1";
					}	
				break;
				case 4://Supprimer ami
					if(($this->Amitie->findCount('amities_users_principal=\''.$this->Session->user('users_id').'\' and amities_users_secondaire=\''.$id.'\' and amities_validation=1')>0 ||
							$this->Amitie->findCount('amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\' and amities_validation=1')>0) && 
							$id!=$this->Session->user('users_id')){
						$amitie=$this->Amitie->findFirst(array(
								'conditions' => '((amities_users_principal=\''.$this->Session->user('users_id').'\' and amities_users_secondaire=\''.$id.'\' and amities_validation=1) or 
												(amities_users_principal=\''.$id.'\' and amities_users_secondaire=\''.$this->Session->user('users_id').'\' and amities_validation=1))'
							)
						);
						$this->Amitie->delete($amitie->amities_id);
						echo "4";
					}else{
						echo "-1";
					}	
				break;
				default:
				break;
			}
		}else{
			echo "non connecte";
		}
	}
	
	
	/**
	* Logout
	**/
	function logout(){
		unset($_SESSION['User']);
		unset($_SESSION['nb_notifications']);
		unset($_SESSION['notifications']);
		$this->Session->setFlash('Vous ête mainenant déconnecté'); 
		$this->redirect('connexion'); 
	}

}