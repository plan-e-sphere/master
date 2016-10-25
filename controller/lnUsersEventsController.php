<?php 
class EventsController extends Controller{
	
	/**
	* Blog, liste les articles
	**/
	function index(){
		if($this->Session->isLogged()){
			$this->loadModel('Event'); 
			$d['events'] = $this->Event->find(array(
				'fields'     => 'Event.events_id,Event.events_libelle,Event.events_date_debut,Event.events_date_fin',
			));
			$this->set($d);
			$this->render('index');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexions/index');
		}
	}

	/**
	* formulaire d'ajout
	**/
	function newEvent(){
		if($this->Session->isLogged()){
			$this->loadModel('Event');
			$this->render('newEvent');
		}else{
			$this->Session->setFlash('Vous devez être connecté pour accéder à cette page','error'); 
			$this->redirect('connexion');
		}
	}
	
	/**
	* affiche un evenement
	**/
	function view($id,$update=null){
		if($this->Session->isLogged()){
			$this->loadModel('Event');
			$d['events'] = $this->Event->findFirst(array(
				'fields'     => 'Event.events_id,Event.events_libelle,Event.events_date_debut,Event.events_date_fin,Event.events_keyword,Event.events_validation,Event.events_nb_participants_max',
				'conditions' => 'Event.events_id='.$id,
			));
			if($d['events']->events_validation == 1){
				$d['events']->events_validation ="Oui";
			}else{
				$d['events']->events_validation ="Non";
			}
			$this->set($d);
			
			if($update!=null){
				$this->render('updateEvent');
			}else{
				$this->render('view');
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
		$this->loadModel('Event'); 
		if($this->request->data){
				$this->request->data->events_date_debut = date("Y-m-d",strtotime($this->request->data->events_date_debut));
				$this->request->data->events_date_fin = date("Y-m-d",strtotime($this->request->data->events_date_fin));
				$this->Event->save($this->request->data);
				if(isset($this->request->data->events_id)){
					$this->Session->setFlash('Le contenu a bien été modifié'); 
					$this->redirect('events/view/'.$this->request->data->events_id);
				}else{
					$this->Session->setFlash('Le contenu a bien été ajouté'); 
					$this->redirect('events/index'); 
				}
		}else{
			$this->Session->setFlash('Merci de corriger vos informations','error'); 
		}
	}
	
	/**
	* Supprime un evenement
	**/
	function delete($id){
		$this->loadModel('Event'); 
		$this->Event->delete($id);
		$this->Session->setFlash('L\'evenement a bien ete supprime'); 
		$this->redirect('events/index'); 
	}
	/**
	* ADMIN  ACTIONS
	**/
	/**
	* Liste les différents articles
	**/
	function admin_index(){
		$perPage = 10; 
		$this->loadModel('Post');
		$condition = array('type'=>'post'); 
		$d['posts'] = $this->Post->find(array(
			'fields'     => 'Post.id,Post.name,Post.online,Category.name as catname,Category.slug as catslug',
			'order' 	 => 'created DESC',
			'conditions' => $condition,
			'limit'      => ($perPage*($this->request->page-1)).','.$perPage,
			'join'		 => array('categories as Category'=>'Category.id=Post.category_id')
		));
		$d['total'] = $this->Post->findCount($condition); 
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}

	/**
	* Permet d'éditer un article
	**/
	function admin_edit($id = null){
		$this->loadModel('Post'); 
		if($id === null){
			$post = $this->Post->findFirst(array(
				'conditions' => array('online' => -1),
			));
			if(!empty($post)){
				$id = $post->id;
			}else{
				$this->Post->save(array(
					'online' => -1,
					'created' 	 => date('Y-m-d')
				));
				$id = $this->Post->id;
			} 
		}
		$d['id'] = $id; 
		if($this->request->data){
			if($this->Post->validates($this->request->data)){
				$this->request->data->type = 'post';

				$this->Post->save($this->request->data);
				$this->Session->setFlash('Le contenu a bien été modifié'); 
				$this->redirect('admin/posts/index'); 
			}else{
				$this->Session->setFlash('Merci de corriger vos informations','error'); 
			}
			
		}else{
			$this->request->data = $this->Post->findFirst(array(
				'conditions' => array('id'=>$id)
			));
		}
		// On veut un sélecteur de catégorie donc on récup la liste des catégories
		$this->loadModel('Category');
		$d['categories'] = $this->Category->findList(); 
		$this->set($d);
	}

	/**
	* Permet de supprimer un article
	**/
	function admin_delete($id){
		$this->loadModel('Post');
		$this->Post->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé'); 
		$this->redirect('admin/posts/index'); 
	}

	/**
	* Permet de lister les contenus
	**/
	function admin_tinymce(){
		$this->loadModel('Post');
		$this->layout = 'modal'; 
		$d['posts'] = $this->Post->find();
		$this->set($d);
	}

}