<?php 
class RecherchesController extends Controller{
	
   function index(){
		$this->loadModel('User'); 
		$this->loadModel('Amitie');
                $this->loadModel('Event'); 
                $this->loadBean('UserBean');
                $this->loadBean('EventBean');
		$users = $this->User->getUsersLike($this->request->data->recherche);
                $d['users']=array();
		foreach ($users as $value) {
                    $user=new UserBean($value);
                    $user->users_amitie=$this->Amitie->isFriend($value->users_id,$this->Session->user('users_id'));
                    array_push($d['users'],$user);
		}
                
                $events = $this->Event->getEventsLike($this->request->data->recherche);
                $d['events']=array();
		foreach ($events as $value) {
                    $event=new EventBean($value);
                    array_push($d['events'],$event);
		}
                $this->set($d);
                $this->render('index');
	}
}