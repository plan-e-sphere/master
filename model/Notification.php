<?php
class Notification extends Model{
	public $primaryKey = 'notifications_id';
	
	public function getNotifByUser($id_user){
		$notifications = $this->find(array(
				'fields'	 => 'User.*, Notification.*, Event.*, Groupe.*',
				'conditions' => array('notifications_users_id'=>$id_user), 
				'join' 		 => array('users as User'=>'User.users_id=notifications_users_emetteur_id',
								'events as Event'=>'Event.events_id=notifications_events_id',
								'groupes as Groupe'=>'Groupe.groupes_id=notifications_events_id'), 
				'order'      => 'Notification.notifications_date DESC',
				'limit'		=> 10,
			));
		return $notifications;
	}
	
	public function createNotif($id_emetteur, $id_destinataire, $id_element, $type){
		$notification=new stdClass();
		$notification->notifications_users_id=$id_destinataire;
		$notification->notifications_users_emetteur_id=$id_emetteur;
		$notification->notifications_events_id=$id_element;
		$notification->notifications_type=$type;
		$notification->notifications_lu=0;
		
		$this->save($notification);
	}
	
	public function lectureNotif($id_notif){
		$notif=$this->findFirst(array(
				'conditions' => array('notifications_id' => $id_notif
				)));
		debug($notif);
		$notif->notifications_lu=1;
		debug($notif);
		$this->save($notif);
	}
}