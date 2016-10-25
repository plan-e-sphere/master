<?php 
class SondagesController extends Controller
{
	function index(){
		if($this->Session->isLogged()){
			$this->loadModel('Sondage'); 
			$this->render('index');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexions');
		}
	}
	
	/* Ajouter un sondage */
	
	function newSondage($event_id){
		if($this->Session->isLogged()){
                        $this->loadBean('SondageBean');
                        $sondage=new SondageBean();		
			$d['sondages']=$sondage;
			$d['event_id']=$event_id;
			$this->set($d);
			$this->render('newSondage');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
        /* Envoie les données à la bdd */
        
	function addSondage($event_id){
		$this->loadBean("SondageBean");
		$sondage=new SondageBean($this->request->data->sondages_libelle,$this->request->data->sondages_request,$event_id);
                $this->loadModel("Sondage");
		$this->Sondage->save($sondage);
		$this->redirect('sondages');
	}
}