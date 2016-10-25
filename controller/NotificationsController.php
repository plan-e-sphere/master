<?php 
class NotificationsController extends Controller{

	function dateTime($date1, $date2){
		$interval = $date1->diff($date2);
		if($interval->format('%y')>0){
			if($interval->format('%y')>1){
				$date = $interval->format('il y a plus d\'un an');
			}else{
				$date = $interval->format('il y a un an');
			}
		}elseif($interval->format('%m')>0){
			if($interval->format('%m')>1){
				$date = $interval->format('il y a %m mois');
			}else{
				$date = $interval->format('il y a %m mois');
			}
		}elseif($interval->format('%d')>0){
			if($interval->format('%d')>1){
				$date = $interval->format('il y a %d jours');
			}else{
				$date = $interval->format('il y a %d jour');
			}
		}elseif($interval->format('%h')>0){
			if($interval->format('%h')>1){
				$date = $interval->format('il y a %h heures');
			}else{
				$date = $interval->format('il y a %h heure');
			}
		}elseif($interval->format('%i')>0){
			if($interval->format('%i')>1){
				$date = $interval->format('il y a %i minutes');
			}else{
				$date = $interval->format('il y a %i minute');
			}
		}else{
			$date='il y a moins d\'une minute';
		}
		return $date;
	}
	
	function text($date, $value){
		$text=new stdClass();
		switch ($value->notifications_type){
			case "demande_ami":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<b>$value->users_pseudo</b> vous a demandé en ami<br/><i>$date</i>";
				$text->url=Router::url('users/profil')."/$value->users_id";
				$text->alerte="";
			break;
			case "invite_event":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<b>$value->users_pseudo</b> vous a invité à l'évènement <b>$value->events_libelle</b><br/><i>$date</i>";
				$text->url=Router::url('events/view')."/$value->events_id";
				$text->alerte="";
			break;
			case "accepter_ami":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<b>$value->users_pseudo</b> a accepté votre demande d'ami<br/><i>$date</i>";
				$text->url=Router::url('users/profil')."/$value->users_id";
				$text->alerte="";
			break;
			case "invite_groupe":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<b>$value->users_pseudo</b> vous a ajouté au groupe <b>$value->groupes_libelle</b><br/><i>$date</i>";
				$text->url=Router::url('groupes/view')."/$value->groupes_id";
				$text->alerte="";
			break;
			case "alerte_sup_groupe":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<img src='".IMG."/picto-attention-rouge.png' width='25'/><b>$value->users_pseudo</b> a tenté de supprimer le groupe <b>$value->groupes_libelle</b><br/><i>$date</i>";
				$text->url=Router::url('groupes/view')."/$value->groupes_id";
				$text->alerte="";
			break;
			case "promotion_groupe_Admin":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<b>$value->users_pseudo</b> vous a promu au rang d'adminitrateur pour le groupe <b>$value->groupes_libelle</b><br/><i>$date</i>";
				$text->url=Router::url('groupes/view')."/$value->groupes_id";
				$text->alerte="";
			break;
			case "promotion_groupe_Modo":
				$text->image="<img class='photo_arrondie_petite' src='$value->users_photo'/>";
				$text->text="<b>$value->users_pseudo</b> vous a promu au rang de modérateur pour le groupe <b>$value->groupes_libelle</b><br/><i>$date</i>";
				$text->url=Router::url('groupes/view')."/$value->groupes_id";
				$text->alerte="";
			break;
			case "exclusion_groupe":
				$text->image="<img src='".IMG."/picto-attention-rouge.png' width='50'/>";
				$text->text="<b>$value->users_pseudo</b> vous a exclu du groupe <b>$value->groupes_libelle</b><br/><i>$date</i>";
				$text->url=Router::url('groupes/view')."/$value->groupes_id";
				$text->alerte="";
			break;
			case "annule_covoit":
				$text->image="<img src='".IMG."/picto-attention-rouge.png' width='50'/>";
				$text->text="<b>$value->users_pseudo</b> &agrave; annul&eacute; son covoiturage pour l'évenement <b>$value->events_libelle</b>";
				$text->url=Router::url('events/view')."/$value->events_id";
				$text->alerte="";
			break;
		}
		return $text;
	}
	
	function verifNotif(){
		$this->loadModel('Notification');
		$nb_notifications = $this->Notification->findCount('notifications_users_id='.$this->Session->user('users_id').' and notifications_lu=0');	
		$this->Session->write('nb_notifications',$nb_notifications);
		
		$notifications = $this->Notification->getNotifByUser($this->Session->User('users_id'));
		
		$notif="";
		foreach ($notifications as $value) {
		
			$date=$this->dateTime(new DateTime($value->notifications_date), new DateTime('NOW'));
			
			if($value->notifications_lu==0){
				$onclick="onclick='notif_lu($value->notifications_id)'";
				$class_lu="non_lu";
			}else{
				$onclick="";
				$class_lu="lu";
			}
			$text=$this->text($date, $value);
			$notif.="<a href='$text->url' $text->alerte class='link col-md-12 $class_lu' $onclick>
				<div class='col-md-3'>$text->image</div>
				<div class='col-md-9'>$text->text</div>
			</a>";			
		}
		$this->Session->write('notifications',$notif);
		echo $notif.'|'.$nb_notifications;
	}
	
	function lectureNotif($id_notif){
		$this->loadModel('Notification');
		$this->Notification->lectureNotif($id_notif);
	}
}