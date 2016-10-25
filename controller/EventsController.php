<?php 
class EventsController extends Controller{
	
	/**
	* Blog, liste les articles
	**/
	function index($filtre=null){
		if($this->Session->isLogged()){
			$this->loadModel('Event'); 
			$this->loadModel('Ln_users_event'); 
                        switch ($filtre){
                            case "public":
                                $d['events'] = $this->Event->getAllEventPublicFuture($this->Session->User("users_id"));
                                $d['title']="Evènements publics";
                                break;
                            case "archive":
                                $d['events'] = $this->Event->getAllEventByUserPass($this->Session->User("users_id"));
                                $d['title']="Mes évènements archivés";
                                break;
                            case "futur":
                                $d['events'] = $this->Event->getAllEventByUserFuture($this->Session->User("users_id"));
                                $d['title']="Mes évènements à venir";
                                break;
                            case "futurMois":
                                $date_next_month =date('Y-m-d H:i:s', strtotime('+1 month'));
                                $d['events'] = $this->Event->getAllEventByUserBetween($this->Session->User("users_id"),$date_next_month);
                                $d['title']="Mes évènements à venir sur le prochain mois";
                                break;
							case "futurSemaine":
                                $date_next_month =date('Y-m-d H:i:s', strtotime('+1 week'));
                                $d['events'] = $this->Event->getAllEventByUserBetween($this->Session->User("users_id"),$date_next_month);
                                $d['title']="Mes évènements à venir sur la prochaine semaine";
                                break;
                            default :
                                $d['events'] = $this->Event->getAllEventByUserFuture($this->Session->User("users_id"));
                                $d['title']="Mes évènements à venir";
                        }
			$this->set($d);
			$this->render('index');
		}else{
			$this->redirect('connexions/index');
		}
	}

	/**
	* formulaire d'ajout
	**/
	function newEvent(){
		if($this->Session->isLogged()){
			$this->loadModel('Event');
			$this->loadModel('Adresse');
			$d['adresses']=$this->Adresse->getAdresseByUser($this->Session->User("users_id"));
			$tab_event=new stdClass();
			$tab_event->events_id="";
			$tab_event->events_libelle="";
			$tab_event->events_date_debut="";
			$tab_event->events_date_fin="";
			$tab_event->events_nb_participants_max="";
			$tab_event->events_validation="";
			$tab_event->events_publication="";
			$tab_event->events_adresses_id="";
			$tab_event->events_covoiturage="";
			$tab_event->events_description="";
			$tab_event->events_image="";
			$tab_event->adresses_id="";
			$d['events']=$tab_event;
			
			$fournitures=new stdClass();
			$d['fournitures']=$fournitures;
			$this->set($d);
			$this->render('newEvent');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	/*
	* inviter un ami à un events	
	**/
	function inviteEvent($idFriend,$idEvent){
		if($this->Session->isLogged()){
			$this->loadModel('Event');
			$this->loadModel('Ln_users_event');
			$this->loadModel('User');
			$this->loadModel('Notification');
			$invitation=array("ln_users_events_id"=>$idFriend.$idEvent,
									"users_users_id"=>$idFriend,
									"events_events_id"=>$idEvent,
									"ln_users_events_role"=>"participant",
									"ln_users_events_accepted"=>0);
			$this->Ln_users_event->save($invitation);
				$this->Session->setFlash('La personne a bien été invite'); 
				$this->redirect('events/view/'.$idEvent);
			$tab_notification=array("notifications_users_id"=>$idFriend,
										"notifications_users_emetteur_id"=>$this->Session->user('users_id'),
										"notifications_events_id"=>$idEvent,
										"notifications_type"=>"invite_event",
										"notifications_lu"=>0);
			$this->Notification->save($tab_notification);
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
		
	}
	
	/*
	* inviter un groupe à un events	
	**/
	function inviteGroupEvent($idGroup,$idEvent){
		if($this->Session->isLogged()){
			$this->loadModel('Groupe');
			$this->loadModel('Ln_users_event');
			foreach($this->Groupe->getAllUsers($idGroup) as $k => $v){
				if(!$this->Ln_users_event->isInvite($idEvent,$v->users_id)){
					$this->inviteEvent($v->users_id,$idEvent);
				}
			}
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
		
	}
	/**
	* affiche un evenement
	**/
	function viewmaps(){
		$this->render('view_localisation');
	}
	function view($id,$update=null){
		if($this->Session->isLogged()){
			$this->loadModel('Event');
			$this->loadModel('Groupe');
			$this->loadModel('Ln_users_event');
			$this->loadModel('User');
			$this->loadModel('Fourniture');
			$this->loadModel('Ln_users_fourniture');
			$this->loadModel('Ln_users_covoiturage');
            $this->loadModel('Sondage');
			$d['events'] = $this->Event->getEventById($id);
			if($this->Event->exist($id)){
				if($d['events']->events_validation == 1){
					$d['events']->events_validation ="Oui";
				}else{
					$d['events']->events_validation ="Non";
				}
				if($d['events']->events_adresses_id != null){
                                    $adresse=  explode("|", $d['events']->events_adresses_id);
                                    $d['events']->adresses_num_voie=$adresse[0];
                                    $d['events']->adresses_voie=$adresse[1];
                                    $d['events']->adresses_cp=$adresse[2];
                                    $d['events']->adresses_ville=$adresse[3];
                                    $d['events']->adresses_pays=$adresse[4];
                                    $d['events']->adresses_lat=$adresse[5];
                                    $d['events']->adresses_lng=$adresse[6];
                                }else{
                                    $d['events']->adresses_num_voie="";
                                    $d['events']->adresses_voie="";
                                    $d['events']->adresses_cp="";
                                    $d['events']->adresses_ville="";
                                    $d['events']->adresses_pays="";
                                    $d['events']->adresses_lat="";
                                    $d['events']->adresses_lng="";
                                }
				//participation du user à l'evenement
				$d['lnUserEvent']=$this->Ln_users_event->getStatutUser($id,$this->Session->User("users_id"));
				
				//Amis
				$param=$this->User->getFriendsListe($this->Session->User("users_id"));
				foreach ($param as $k=>$v){
					if($this->Ln_users_event->isInvite($id,$v->users_id)==true){
						$v->invit=true;
					}
					else if($this->Ln_users_event->isInvite($id,$v->users_id)==false){
						$v->invit=false;
					}	
					
				}
				$d['friendsList']= $param;
				
				//Groupes
				$d['groupsList']=$this->Groupe->getListGroupeByUser($this->Session->User("users_id"));
				
				//Fournitures
				$fournitures=$this->Fourniture->find(array(
					'fields'		=>'Fourniture.*',
					'conditions'	=>'Fourniture.events_events_id='.$id,
				));
				foreach ($fournitures as $k=>$v){
					$v->quantiteRestante=$this->Fourniture->getQteFounitureRestante($v->fournitures_id);
				}
				$d['fournitures']=$fournitures;
				
				//*************COVOITURAGE**************
				$d['tripStaut']=$this->Ln_users_covoiturage->getTripStatut($this->Session->User("users_id"),$id);
				$d['covoit'] = $this->Ln_users_covoiturage->getCovoitChoice($id,$this->Session->User("users_id"));
				$d['chauffeur'] = $this->Ln_users_covoiturage->getChauffeur($this->Session->User("users_id"),$id);
				//**********************NB PARTICIPANTS ****************
				$nbParticipants=$this->Ln_users_event->getNbParticipants($id);
				$nbMaxParticipants=$this->Event->getNbMaxParticipants($id);
				if($nbParticipants>=$nbMaxParticipants->events_nb_participants_max){
					$d['placesDispo']=0;
				}
				else{
					$d['placesDispo']=1;
				}

				//************************************************************
                                //Sondage
                                $d['sondages']=$this->Sondage->getSondagesByEvent($id);
				
				if($update=="update"){
					$this->loadModel('Adresse');
					$d['adresses']=$this->Adresse->getAdresseByUser($this->Session->User("users_id"));
					$this->set($d);
					$this->render('newEvent');
				}elseif ($update==null) {
					$this->set($d);
					$this->render('view');
				}else{
                                    $this->e404("L'évènement que vous recherchez n'existe pas ou a été supprimé"); 
                                }
			}else{
				$this->e404("L'évènement que vous recherchez n'existe pas ou a été supprimé"); 
			}
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
	function addVoiture($idEvent, $idChauffeur, $voiture){
		$this->loadModel('Ln_users_covoiturage');
		$this->loadModel('Covoiturage');
		$covoit=json_decode($voiture);
		$this->Covoiturage->addCovoiturage($idEvent,$covoit);
		$this->Ln_users_covoiturage->addPassager($idEvent,$idChauffeur,"1",$this->Covoiturage->id);
		//$this->Session->setFlash('Votre voiture est lié  ','error'); 
	}
	
	function view_covoit($eventId){
		$this->loadModel('Ln_users_covoiturage');
		$this->loadModel('Event');
		$d['tripStaut']=$this->Ln_users_covoiturage->getTripStatut($this->Session->User("users_id"),$eventId);
		$d['covoit'] = $this->Ln_users_covoiturage->getCovoitChoice($eventId,$this->Session->User("users_id"));
		$d['chauffeur'] = $this->Ln_users_covoiturage->getChauffeur($this->Session->User("users_id"),$eventId);
		$d['events'] = $this->Event->getEventById($eventId);
		if($this->Event->exist($eventId)){
			if($d['events']->events_validation == 1){
					$d['events']->events_validation ="Oui";
			}else{
					$d['events']->events_validation ="Non";
			}
		}
		$this->set($d); 
		$this->renderWithoutTemplate("view_covoiturage");
	}
	
	function passagers($eventId, $userId, $idChauffeur){
		$this->loadModel('Ln_users_covoiturage');
		$this->loadModel('Event');
		$idLnUserCovoit = $this->Ln_users_covoiturage->getIDlnUserCovoit($eventId, $idChauffeur);
		$listePassagers = $this->Ln_users_covoiturage->getListPassager($idLnUserCovoit);
		$d['tripStaut']=$this->Ln_users_covoiturage->getTripStatut($this->Session->User("users_id"),$eventId);
		$d['events'] = $this->Event->getEventById($eventId);
			if($this->Event->exist($eventId)){
				if($d['events']->events_validation == 1){
					$d['events']->events_validation ="Oui";
				}else{
					$d['events']->events_validation ="Non";
				}
			}
		$d['covoit'] = $listePassagers;
		$d['chauffeur'] = $this->Ln_users_covoiturage->getChauffeur($this->Session->User("users_id"),$eventId);
		$this->set($d);
		$this->renderWithoutTemplate("view_covoiturage");
		
	}
	
	function addPassager($eventId, $userId, $userIdChauffeur){
			$this->loadModel('Ln_users_covoiturage');
			if($this->Ln_users_covoiturage->getTripStatut($userId, $eventId)=="visiteur"){
			$covoitId=$this->Ln_users_covoiturage->getCovoit($userIdChauffeur,$eventId);
			$this->Ln_users_covoiturage->addPassager($eventId,$userId,0,$covoitId);
		}
		else{
			$this->Session->setFlash('Vous êtes déjà dans un covoiturage  ','error');
		}
		$this->view_covoit($eventId);
	}
	
	function removePassager($eventId, $userId){
		$this->loadModel('Ln_users_covoiturage');
		$this->loadModel('Covoiturage');
		$this->loadModel('Notification');
		$statut = $this->Ln_users_covoiturage->getTripStatut($userId,$eventId);
		$listeId=$this->Ln_users_covoiturage->removePassager($eventId, $userId);
		//echo $statut;
		if($statut=="chauffeur"){
				debug($listeId);
				$this->Covoiturage->removeCovoiturage($listeId[0]->ln_users_covoiturage_covoiturage_id);
				foreach ($listeId as $k => $v):
					if($v->ln_users_covoiturage_users != $this->Session->user('users_id')){
						$this->Notification->createNotif($userId, $v->ln_users_covoiturage_users ,$eventId, "annule_covoit");
					}
				endforeach;		
		}
		$this->view_covoit($eventId);
	}
	
	
	/**
	* Ajout un evenement
	**/
	function add(){
		$this->loadModel('Event'); 
                $this->loadModel('Adresse'); 
		$this->loadModel('Ln_users_event');
		$this->loadModel('Fourniture');
		if($this->request->data){
			$this->request->data->events_date_debut = date("Y-m-d H:i",strtotime($this->request->data->events_date_debut));
			if(empty($this->request->data->events_date_fin)){	
				$this->request->data->events_date_fin=null;
			}else{
				$this->request->data->events_date_fin = date("Y-m-d H:i",strtotime($this->request->data->events_date_fin));
			}
			if(isset($this->request->data->events_id)){
				$events_id=$this->request->data->events_id;
				if(isset($this->request->data->fournitures_id)){
					$this->Fourniture->deleteFourniture($events_id,$this->request->data->fournitures_id);
				}else{
					$this->Fourniture->deleteFourniture($events_id,array(0));
				}
			}else{
				$events_id='';
			}
                        if(!empty($this->request->data->adresses_num_voie)){
                            
                            // Google Maps Geocoder
                            $geocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false&language=fr";
                            $adress=$this->request->data->adresses_num_voie.' '.$this->request->data->adresses_voie.' '.$this->request->data->adresses_cp.' '.$this->request->data->adresses_ville.' '.$this->request->data->adresses_pays;
                            $query = sprintf($geocoder, urlencode($adress));
                            $result = json_decode(file_get_contents($query));
                            $json = $result->results[0];
                            $adresses_lat = (string) $json->geometry->location->lat;
                            $adresses_lng = (string) $json->geometry->location->lng;
                            $adresse=$this->request->data->adresses_num_voie.'|'.$this->request->data->adresses_voie.'|'.$this->request->data->adresses_cp.'|'
                                    .$this->request->data->adresses_ville.'|'.$this->request->data->adresses_pays.'|'.$adresses_lat.'|'.$adresses_lng;
                            if(!empty($this->request->data->adresses_libelle)){
                                $adresseUser=new stdClass();
                                $adresseUser->adresses_users_id=$this->Session->User('users_id');
                                $adresseUser->adresses_libelle=$this->request->data->adresses_libelle;
                                $adresseUser->adresses_num_voie=$this->request->data->adresses_num_voie;    
                                $adresseUser->adresses_voie=$this->request->data->adresses_voie;
                                $adresseUser->adresses_cp=$this->request->data->adresses_cp;
                                $adresseUser->adresses_ville=$this->request->data->adresses_ville;
                                $adresseUser->adresses_pays=$this->request->data->adresses_pays;
                                $adresseUser->adresses_lat=$adresses_lat;
                                $adresseUser->adresses_lng=$adresses_lng;
                                $this->Adresse->save($adresseUser);
                            }
                            
                        }else{
                            $adresse=null;
                        }
			$tab_event=new stdClass();
			$tab_event->events_id=$events_id;
			$tab_event->events_libelle=htmlspecialchars($this->request->data->events_libelle);
			$tab_event->events_date_debut=htmlspecialchars($this->request->data->events_date_debut);
			$tab_event->events_date_fin=htmlspecialchars($this->request->data->events_date_fin);
			$tab_event->events_keyword=htmlspecialchars($this->request->data->events_keyword);
			$tab_event->events_nb_participants_max=htmlspecialchars($this->request->data->events_nb_participants_max);
			$tab_event->events_validation=htmlspecialchars($this->request->data->events_validation);
			$tab_event->events_publication=htmlspecialchars($this->request->data->events_publication);
			$tab_event->events_adresses_id=htmlspecialchars($adresse);
			$tab_event->events_covoiturage=htmlspecialchars($this->request->data->events_covoiturage);
			$tab_event->events_description=htmlspecialchars($this->request->data->events_description);
			$tab_event->events_image=htmlspecialchars($this->request->data->events_image);

			if(date("Ymd",strtotime($tab_event->events_date_fin))== '19700101'){
				$tab_event->events_date_fin="";
			}
			//Vérification des données
			$tab_event_check=array("events_libelle"=>"");
			$checkFormulaire=1;
			if(empty($tab_event->events_libelle)){
				$checkFormulaire=0;
				$tab_event_check["events_libelle"]="error_form";
			}

			if(empty($tab_event->events_date_debut) || new DateTime() > new DateTime($tab_event->events_date_debut)){
				$checkFormulaire=0;
				$tab_event_check["events_date_debut"]="error_form";
			}
			
			if(!empty($tab_event->events_date_fin) && new DateTime($tab_event->events_date_debut) > new DateTime($tab_event->events_date_fin)){
				$checkFormulaire=0;
				$tab_event_check["events_date_fin"]="error_form";
			}
			$tab_fourniture = array();
			if(isset($this->request->data->fournitures_libelle)){
				for ($cptFour=0;$cptFour<sizeof($this->request->data->fournitures_libelle);$cptFour++){
					if(trim($this->request->data->fournitures_libelle[$cptFour])!=""){
						if(isset($this->request->data->fournitures_id[$cptFour])){
							$fournitures_id=$this->request->data->fournitures_id[$cptFour];
						}else{
							$fournitures_id='';
						}
						$fournitures_object = new stdClass();
						$fournitures_object->fournitures_id=$fournitures_id;
						$fournitures_object->fournitures_libelle=$this->request->data->fournitures_libelle[$cptFour];
						$fournitures_object->fournitures_quantite=$this->request->data->fournitures_qte[$cptFour];
						$fournitures_object->fournitures_unite=$this->request->data->fournitures_unite[$cptFour];
						$fournitures_object->fournitures_requis="1";
						array_push($tab_fourniture,$fournitures_object);
					}
				}
			}
			if($checkFormulaire){
				$this->Event->save($tab_event);

				$tab_ln_users_event=array("ln_users_events_id"=>$this->Session->user('users_id').''.$this->Event->id,
										"users_users_id"=>$this->Session->user('users_id'),
										"events_events_id"=>$this->Event->id,
										"ln_users_events_role"=>"createur",
										"ln_users_events_accepted"=>$this->request->data->events_validation);
				$this->Ln_users_event->save($tab_ln_users_event);
				
				//enregistrement des fournitures
				foreach($tab_fourniture as $k=>$v){
					$v->events_events_id=$this->Event->id;
					$this->Fourniture->save($v);
				}
				//--------------------------
				if(isset($this->request->data->events_id)){
					$this->Session->setFlash('Le contenu a bien été modifié'); 
					$this->redirect('events/view/'.$this->Event->id);
				}else{
					$this->Session->setFlash('Le contenu a bien été ajouté'); 
					$this->redirect('events/index'); 
				}
			}else{
				$this->loadModel('Adresse');
				$this->Session->setFlash('Merci de corriger les informations','error'); 
				$d["events"]=$tab_event;
				$d["form"]=$tab_event_check;
				$d["fournitures"]=$tab_fourniture;
				$d['adresses']=$this->Adresse->getAdresseByUser($this->Session->User("users_id"));
				$this->set($d);
				$this->render('newEvent'); 
			}
		}else{
			$this->Session->setFlash('Merci de corriger vos informations','error'); 
		}
	}
	
	/**
	* acceptation / refus de l'events
	**/
	function acceptRefuse($userID,$eventID,$choix){
		$this->loadModel('Ln_users_event');
		$this->loadModel('Ln_users_covoiturage');
		$this->loadModel('User');
        $this->loadModel('Event');
		$accessBdd=true;
		$statut = $this->Ln_users_covoiturage->getTripStatut($userID,$eventID);
		if($statut == "passager" || $statut == "chaffeur"){
			$this->removePassager($eventID,$userID);
			if($statut=="chaffeur"){
				foreach ($user_covoit as $k => $v):
					createNotif($userID, $v, $eventID, "annule_covoit");
				endforeach;
				
			}
		}
		if ($choix=="1") {
			$nbParticipants=$this->Ln_users_event->getNbParticipants($eventID);
			$nbMaxParticipants=$this->Event->getNbMaxParticipants($eventID)->events_nb_participants_max;
			$alert_message="Vous êtes bien inscrit à l'évènement";
			if ($nbParticipants>=$nbMaxParticipants) {
			  		$alert_message="vous êtes en liste d'attente";
			}  	
		}
		elseif ($choix=="2") {
		  	$alert_message="Choix enregistré";
		}
		elseif ($choix=="-1") {
		  	$alert_message="Refus de l'invitation enregistré";
		}  
		$accept=array("ln_users_events_id"=>$userID.$eventID,
					"users_users_id"=>$userID,
					"events_events_id"=>$eventID,
					"ln_users_events_accepted"=>$choix,
					"ln_users_events_date_reponse"=>date("Y-m-d H:i:s.u"));
		$this->Ln_users_event->save($accept);
		
		
		echo $choix.";".$alert_message;	
	}
	
	/**
	* Supprime un evenement
	**/
	function delete($id){
		$this->loadModel('Event'); 
		$this->loadModel('Ln_users_event');
		foreach($this->Ln_users_event->find(array(
				'fields'     => 'Ln_users_event.ln_users_events_id',
				'conditions'	=> 'events_events_id='.$id,)) as $value){
			$this->Ln_users_event->delete($value->ln_users_events_id);
		}
		$this->Event->delete($id);
		$this->Session->setFlash('L\'evenement a bien ete supprime'); 
		$this->redirect('events/index'); 
	}
	
	function ajax($function, $idEvent=null){
		switch ($function){
			case "participants" :
				$this->loadModel('Ln_users_event');
				$usersAcceptedList=$this->Ln_users_event->getUsersAccepted($idEvent);
				$usersRefusedList=$this->Ln_users_event->getUsersRefused($idEvent);
				$usersInvitedList=$this->Ln_users_event->getUsersInvited($idEvent);
				$usersMaybeList=$this->Ln_users_event->getUsersMaybe($idEvent);
				$this->loadModel('Event');
				$nbMaxParticipants=$this->Event->getNbMaxParticipants($idEvent);
				$nbMaxParticipants=$nbMaxParticipants->events_nb_participants_max;
				$compteur=0;
				$listeAttente= array();
				$isOnWaitingList=false;
				//debug($nbMaxParticipants);
				$nbParticipants=count($usersAcceptedList);
				if ($nbMaxParticipants<count($usersAcceptedList)) {
					$nbParticipants=$nbMaxParticipants;
				}

				echo '<button type="button" class="btn btn-default"
						data-toggle="popover" title="Participent" data-html="true" data-trigger="click"
						data-content="';
				foreach ($usersAcceptedList as $k => $v){
						if ($compteur<$nbMaxParticipants) {
							echo "<div class='col-md-3 text-center'>
									<img src='$v->users_photo' alt='photo de profil' class='photo_arrondie_petite'></img>
									<div>AKA : $v->users_pseudo<br/><i>$v->users_nom $v->users_prenom</i></div>
								</div>";
							
						}else{
							if ($v->users_id==$this->Session->User("users_id")) {
								$isOnWaitingList=true;
							}
							array_push($listeAttente, $v);
						}
						$compteur++;
				}
				echo '" data-placement="bottom"> 
					Présent(s) ('.$nbParticipants.')
				</button>';

				//liste d'attente 
				echo '<button type="button" class="btn btn-default"
						data-toggle="popover" title="listeAttente" data-html="true" data-trigger="click"
						data-content="';
				foreach ($listeAttente as $k => $v){
					echo "<div class='col-md-3 text-center'>
							<img src='$v->users_photo' alt='photo de profil' class='photo_arrondie_petite'></img>
							<div>AKA : $v->users_pseudo<br/><i>$v->users_nom $v->users_prenom</i></div>
						</div>";
				}
				if ($isOnWaitingList) {
					echo '" data-placement="bottom"> 
						<b>Vous êtes en liste d\'attente </b> ('.sizeof($listeAttente).')
					</button>';
				}
				else{
					echo '" data-placement="bottom"> 
						liste d\'attente ('.sizeof($listeAttente).')
					</button>';
				}
				//fin de liste d'attente
				
				echo ' <button type="button" class="btn btn-default"
						data-toggle="popover" title="Indécis" data-html="true" data-trigger="click"
						data-content="';
				foreach ($usersMaybeList as $k => $v){
						echo "<div class='col-md-3 text-center'>
								<img src='$v->users_photo' alt='photo de profil' class='photo_arrondie_petite'></img>
								<div>AKA : $v->users_pseudo<br/><i>$v->users_nom $v->users_prenom</i></div>
							</div>";
				}
				echo '" data-placement="bottom"> 
					Indécis ('.count($usersMaybeList).')
				</button>';
				
				echo ' <button type="button" class="btn btn-default"
						data-toggle="popover" title="Ne participent pas" data-html="true" data-trigger="click"
						data-content="';
				foreach ($usersRefusedList as $k => $v){
						echo "<div class='col-md-3 text-center'>
								<img src='$v->users_photo' alt='photo de profil' class='photo_arrondie_petite'></img>
								<div>AKA : $v->users_pseudo<br/><i>$v->users_nom $v->users_prenom</i></div>
							</div>";
				}
				echo '" data-placement="bottom-left"> 
					Absent(s) ('.count($usersRefusedList).')
				</button>';
				
				echo ' <button type="button" class="btn btn-default"
						data-toggle="popover" title="Invités" data-html="true" data-trigger="click"
						data-content="';
				foreach ($usersInvitedList as $k => $v){
						echo "<div class='col-md-3 text-center'>
								<img src='$v->users_photo' alt='photo de profil' class='photo_arrondie_petite'></img>
								<div>AKA : $v->users_pseudo<br/><i>$v->users_nom $v->users_prenom</i></div>
							</div>";
				}
				echo '" data-placement="bottom-left"> 
					Invité(s) ('.count($usersInvitedList).')
				</button>';
			break;
			case "conducteurs" :
				$this->loadModel('Ln_users_event');
				$usersAcceptedList=$this->Ln_users_event->getUsersAccepted($idEvent);
				
				foreach ($usersAcceptedList as $k => $v){
						echo "<div>
								<img src='$v->users_photo' alt='photo de profil' class='photo_arrondie_petite'></img>
								<button style='margin-left:20px;'> 
									Monter avec cette personne 
								</button>
								<div>AKA : $v->users_pseudo<br/><i>$v->users_nom $v->users_prenom</i>
								<br/><br/></div></div>";
				}
			break;
			
		}
	}
}
