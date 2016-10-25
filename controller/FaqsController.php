<?php 
class FaqsController extends Controller{
	
	function index(){
            $this->loadModel("Faq");
			$this->loadModel("User");
			$d['statut']=$this->User->getStatut($this->Session->User("users_id"));
            $categories=$this->Faq->getCategories();
            $objet = new stdClass();
            $i=0;
            foreach ($categories as $k=>$v):
				$cat=new stdClass();
				$cat->name=$v->faqs_categorie;
				$cat->faqs=$this->Faq->getFaqsByCategorie($v->faqs_categorie);
				$objet->$i=$cat;
				$i++;
			endforeach;
			$d['faqs']=$objet;
			$this->set($d);
			$this->render('faq');
	}
        
        /* Ajouter une faq */
	
	function newFaq(){
		if($this->Session->user('users_statut')=="admin"){
			$this->loadBean('FaqBean');
			$id=$this->FaqBean->getFaqs_id();
			$faqs=new FaqBean(); 		
			$d['faq']=$faqs;
			$this->set($d);
			$this->render('newFaq'); }
		else {
			$this->Session->setFlash('Vous devez être administrateur pour accéder à cette page','error');
			$this->redirect('');
		}
	}
        
        /* Ajoute une faq à la bdd */
        
	function addFaq($id){
		$this->loadBean("FaqBean");
                $this->loadModel('Faq');
                $d['faqs'] = $this->Faq->getFaqsByid($id);
                if($this->Faq->exist($id)){
                    $faq=new FaqBean($id, $this->request->data->faqs_request,$this->request->data->faqs_answer,$this->request->data->faqs_categorie);
                    $this->Faq->save($faq);
                } else {
                    $faq=new FaqBean($this->request->data->faqs_request,$this->request->data->faqs_answer,$this->request->data->faqs_categorie);
                    $this->Faq->save($faq);
                }
		$this->redirect('faqs');
	}
        
        /**
	* Supprime une faq
	**/
	function delete($id){
            $this->loadBean('FaqBean');
            $this->loadModel("Faq");
            $this->Faq->delete($id);
            $this->redirect('faqs');
	}        
        
        /**
	* Modifie une faq
	**/
        function updateFaq($id,$update=null){
            $this->loadModel('Faq');
            $this->loadBean('FaqBean');
            $d['faq'] = $this->Faq->getFaqsByid($id);
            if($this->Faq->exist($id)){
                if($update=="update"){
                    //$d['faq']=new FaqBean($id,$request,$this->FaqBean->getFaqs_answer(),$this->FaqBean->getFaqs_categorie());
                    $this->set($d);
                    $this->render('newFaq');
                }elseif ($update==null) {
                    $this->set($d);
                    $this->render('faq');
                }else{
                    $this->e404("L'élément que vous recherchez n'existe pas ou a été supprimé"); 
                }	
            }	


        
	}
}