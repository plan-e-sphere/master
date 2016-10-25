<?php
class User extends Model{
	public $primaryKey = 'users_id';

	public function getFriendsListe($userId){
		$friendsListe=$this->find(array(
				'fields'		=>'User.users_id, User.users_nom, User.users_prenom, User.users_photo,User.users_pseudo',
				'conditions'		=>'(User.users_id = amitie.amities_users_principal AND amitie.amities_users_secondaire ='.$userId.')
									   OR 
										(amitie.amities_users_principal ='.$userId.' AND User.users_id = amitie.amities_users_secondaire)
									   AND
									amitie.amities_validation = 1',
				'join'          => array('amities as amitie'=>' amitie.amities_users_principal=User.users_id OR amitie.amities_users_secondaire=User.users_id'),
			));
		return $friendsListe;
	}
		
	public function exist_fb($id){
		if($this->findCount('users_login_fb=\''.$id.'\'')>0){
			$response=true;
		}else{
			$response=false;
		}
		return $response;
	}
	
	public function exist($email){
		if($this->findCount('users_login=\''.$email.'\'')>0){
			$response=true;
		}else{
			$response=false;
		}
		return $response;
	}
	
	public function findByLogin($email){
		$user=$this->findFirst(array(
					'conditions' => array('users_login' => $email)
				));
		return $user;
	}
	
	public function findByLoginFb($id){
		$user=$this->findFirst(array(
					'conditions' => array('users_login_fb' => $id)
				));
		return $user;
	}
	
	public function getStatut($userId){
                $statut=$this->findFirst(array(
                    'fields'	=> 'User.users_statut',
                    'conditions' => array('users_id'=>$userId)
                ));
                return $statut;
        }
        
        public function getUsersLike($recherche){
            $users=$this->find(array(
                'fields'     => 'User.*',
                'conditions' => '(User.users_pseudo like \'%'.$recherche.'%\'
                        OR User.users_prenom like \'%'.$recherche.'%\'
                        OR User.users_nom like \'%'.$recherche.'%\')',
                ));
            return $users;
        }
}