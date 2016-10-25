<?php 
class PanelAdminController extends Controller{
	
	function index(){
		/*$d['statut']=$this->User->getStatut($this->Session->User("users_id"));
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
                $this->set($d);*/
                if($this->Session->user('users_statut')=="admin"){
                    $this->render('index');
                } else {
                $this->Session->setFlash('Vous devez être administrateur pour accéder à cette page','error');
                $this->redirect('');
                }
	}
        
}