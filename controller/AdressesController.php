<?php 
class AdressesController extends Controller{
	
	function getAdresseByLibelle($users_id, $libelle){
		$this->loadModel('Adresse');
		$adresse=$this->Adresse->getAdresseByLibelle($users_id, $libelle);
		echo $adresse;
	}
	
	function getAdresseById($id){
		$this->loadModel('Adresse');
		$adresse=$this->Adresse->getAdresseById($id);
                $adresse_string="{\"adresses_libelle\":\"".$adresse->adresses_libelle;
                $adresse_string.="\",\"adresses_num_voie\":\"".$adresse->adresses_num_voie;
                $adresse_string.="\",\"adresses_voie\":\"".$adresse->adresses_voie;
                $adresse_string.="\",\"adresses_cp\":\"".$adresse->adresses_cp;
                $adresse_string.="\",\"adresses_ville\":\"".$adresse->adresses_ville;
                $adresse_string.="\",\"adresses_pays\":\"".$adresse->adresses_pays."\"}";
		echo $adresse_string;
	}
	
	function getAdresseByUser($users_id){
		$this->loadModel('Adresse');
		$adresse=$this->Adresse->getAdresseByUser($users_id);
		$liste="<option>---- Selectionner une adresse ----</option>";
		foreach($adresse as $k=>$v){
			$liste.="<option value='".$v->adresses_id."'>".$v->adresses_libelle."</option>";
		}
		echo $liste;
	}
	
	function addAdresse($adresse){
		// Google Maps Geocoder
		$geocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false&language=fr";

		$this->loadModel('Adresse');
		$adresse=json_decode($adresse);
		$adresse->adresses_users_id=$this->Session->User('users_id');
		
		$adress=$adresse->adresses_num_voie.' '.$adresse->adresses_voie.' '.$adresse->adresses_cp.' '.$adresse->adresses_ville.' '.$adresse->adresses_pays;
		$query = sprintf($geocoder, urlencode($adress));
		$result = json_decode(file_get_contents($query));
		$json = $result->results[0];
		$adresse->adresses_lat = (string) $json->geometry->location->lat;
		$adresse->adresses_lng = (string) $json->geometry->location->lng;
		$this->Adresse->save($adresse);
                
                $d['adresses'] = $this->Adresse->find(array(
                        'conditions' => array('adresses_users_id' => $this->Session->User("users_id")
                )));
                $this->set($d);
                $this->renderWithoutTemplate('listeAdresses');
	}
        
        function mesAdresses($update=null){
            if($this->Session->isLogged()){
                $this->loadModel('Adresse');
                $d['adresses'] = $this->Adresse->find(array(
                        'conditions' => array('adresses_users_id' => $this->Session->User("users_id")
                )));
                $this->set($d);
                if($update!=null){
                        $this->render('updateProfil');
                }else{
                        $this->render('mesAdresses');
                }
            }else{
                    $this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
                    $this->redirect('connexion');
            }
        }
        
        /**
	* Modifie une adresse
	**/
	function update($id,$id_user,$adresse){
            if($this->Session->isLogged()){
                if($this->Session->User("users_id")===$id_user){
                    // Google Maps Geocoder
                    $geocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false&language=fr";

                    $this->loadModel('Adresse');
                    $adresse=json_decode($adresse);
                    $adresse->adresses_id=$id;
                    $adresse->adresses_users_id=$id_user;

                    $adress=$adresse->adresses_num_voie.' '.$adresse->adresses_voie.' '.$adresse->adresses_cp.' '.$adresse->adresses_ville.' '.$adresse->adresses_pays;
                    $query = sprintf($geocoder, urlencode($adress));
                    $result = json_decode(file_get_contents($query));
                    $json = $result->results[0];
                    $adresse->adresses_lat = (string) $json->geometry->location->lat;
                    $adresse->adresses_lng = (string) $json->geometry->location->lng;
                    $this->Adresse->save($adresse);
                    
                    $d['adresses'] = $this->Adresse->find(array(
                            'conditions' => array('adresses_users_id' => $this->Session->User("users_id")
                    )));
                    $this->set($d);
                    $this->renderWithoutTemplate('listeAdresses');
                }else{
                   $this->Session->setFlash('Cette adresse ne vous appartient pas !','error'); 
                   $this->redirect('adresses/mesAdresses'); 
                }
            }else{
                    $this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
                    $this->redirect('connexion');
            }
	}
        
        /**
	* Supprime une adresse
	**/
	function delete($id,$id_user){
            if($this->Session->isLogged()){
                if($this->Session->User("users_id")===$id_user){
                    $this->loadModel('Adresse');
                    $this->Adresse->delete($id);
                    
                    $d['adresses'] = $this->Adresse->find(array(
                            'conditions' => array('adresses_users_id' => $this->Session->User("users_id")
                    )));
                    $this->set($d);
                    $this->renderWithoutTemplate('listeAdresses');
                }else{
                   $this->Session->setFlash('Cette adresse ne vous appartient pas !','error'); 
                   $this->redirect('adresses/mesAdresses'); 
                }
            }else{
                    $this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
                    $this->redirect('connexion');
            }
	}
}
   
  