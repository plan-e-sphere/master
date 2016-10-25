<?php
class Event extends Model{
	public $primaryKey = 'events_id';
	
        public function getNbMaxParticipants($id_event){
            $nbMaxParticipants=$this->findFirst(array(
				'fields'     => 'Event.events_nb_participants_max',
				'conditions' => array('Event.events_id'=>$id_event)));
		return $nbMaxParticipants;
        }
        
	public function getRole($events_id,$user_id){
		$sql = "SELECT Ln_users_event.ln_users_event_role FROM ln_users_events as Ln_users_event WHERE events_events_id = ".$events_id ."AND users_users_id = ".$user_id;
		$this->db->query($sql); 
	}
	
	public function getEventById($events_id){
		$event=$this->findFirst(array(
				'fields'     => 'Event.*,Ln_users_event.*,User.users_pseudo',
				'conditions' => array('Event.events_id'=>$events_id,'Ln_users_event.ln_users_events_role'=>'createur'),
				'join'       => array('ln_users_events as Ln_users_event'=>'Ln_users_event.events_events_id=Event.events_id', 
										'users as User'=>'Ln_users_event.users_users_id=User.users_id'),
			));
		return $event;
	}
	
	public function getAllEventByUserPass($users_id){
		$events=$this->find(array(
				'fields'     => 'Event.*, Ln_users_event.*, Adresse.*',
				'conditions' => '(Event.events_validation=1
									OR (Ln_users_event.users_users_id='.$users_id.' 
										AND Ln_users_event.ln_users_events_role in (\'createur\',\'moderateur\')))
								AND Ln_users_event.users_users_id='.$users_id.'
								AND Event.events_date_fin<NOW()
								AND Event.events_date_debut<NOW()',
				'join'		 =>  array('ln_users_events as Ln_users_event'=>' Ln_users_event.events_events_id=Event.events_id',
										'adresses as Adresse'=>'Adresse.adresses_id=Event.events_adresses_id'), 
				'order'		=>	'Event.events_date_debut desc',
			));
		return $events;
	}
	
	public function getAllEventByUserFuture($users_id){
		$events=$this->find(array(
				'fields'     => 'Event.*, Ln_users_event.*, Adresse.*',
				'conditions' => '(Event.events_validation=1
									OR (Ln_users_event.users_users_id='.$users_id.' 
										AND Ln_users_event.ln_users_events_role in (\'createur\',\'moderateur\')))
								AND Ln_users_event.users_users_id='.$users_id.'
								AND (Event.events_date_fin>=NOW()
									Or Event.events_date_debut>=NOW())',
				'join'		 =>  array('ln_users_events as Ln_users_event'=>' Ln_users_event.events_events_id=Event.events_id',
										'adresses as Adresse'=>'Adresse.adresses_id=Event.events_adresses_id'), 
				'order'		=>	'Event.events_date_debut asc',
			));
		return $events;
	}
	public function getAllEventByUserBetween($users_id, $date_next_month){
		$events=$this->find(array(
				'fields'     => 'Event.*, Ln_users_event.*, Adresse.*',
				'conditions' => '(Event.events_validation=1
									OR (Ln_users_event.users_users_id='.$users_id.' 
										AND Ln_users_event.ln_users_events_role in (\'createur\',\'moderateur\')))
								AND Ln_users_event.users_users_id='.$users_id.'
								AND (Event.events_date_debut<=NOW()
									OR Event.events_date_debut<="'.$date_next_month.'"
									)',
				'join'		 =>  array('ln_users_events as Ln_users_event'=>' Ln_users_event.events_events_id=Event.events_id',
										'adresses as Adresse'=>'Adresse.adresses_id=Event.events_adresses_id'), 
				'order'		=>	'Event.events_date_debut asc',
			));
		return $events;
	}
	
	public function getAllEventPublicPass($users_id){
		$events=$this->find(array(
				'fields'     => 'Event.*, Ln_users_event.*, Adresse.*',
				'conditions' => 'Event.events_validation=1
								AND (
									Event.events_publication=\'Public\'
										AND ((
												(SELECT count(*) 
												FROM ln_users_events as Ln_users_event_count 
												WHERE (Ln_users_event_count.users_users_id='.$users_id.' 
													AND Ln_users_event_count.events_events_id=Event.events_id))=0
											)
											OR 
											(Ln_users_event.users_users_id='.$users_id.'))
									)	
								AND Event.events_date_fin<NOW()
								AND Event.events_date_debut<NOW()',
				'join'		 =>  array('ln_users_events as Ln_users_event'=>' Ln_users_event.events_events_id=Event.events_id',
										'adresses as Adresse'=>'Adresse.adresses_id=Event.events_adresses_id'), 
				'order'		=>	'Event.events_date_debut desc',
			));
		return $events;
	}
	
	public function getAllEventPublicFuture($users_id){
		$events=$this->find(array(
				'fields'     => 'Event.*, Ln_users_event.*, Adresse.*',
				'conditions' => 'Event.events_validation=1
								AND (
									Event.events_publication=\'Public\'
										AND ((
												(SELECT count(*) 
												FROM ln_users_events as Ln_users_event_count 
												WHERE (Ln_users_event_count.users_users_id='.$users_id.' 
													AND Ln_users_event_count.events_events_id=Event.events_id))=0
											)
											OR 
											(Ln_users_event.users_users_id='.$users_id.'))
									)		
								AND (Event.events_date_fin>=NOW()
									Or Event.events_date_debut>=NOW())',
				'join'		 =>  array('ln_users_events as Ln_users_event'=>' Ln_users_event.events_events_id=Event.events_id',
										'adresses as Adresse'=>'Adresse.adresses_id=Event.events_adresses_id'), 
				'order'		=>	'Event.events_date_debut asc',
			));
		return $events;
	}
        
        public function getEventsLike($recherche){
            $events=  $this->find(array(
                'fields'     => 'Event.*',
                'conditions' => 'Event.events_libelle like \'%'.$recherche.'%\'
                     OR Event.events_description like \'%'.$recherche.'%\'', 
            ));
            return $events;
        }
}