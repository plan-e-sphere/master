<?php
class EventBean{
    
        public $events_id;
        public $events_libelle;
        public $events_date_debut;
        public $events_date_fin;
        public $events_nb_participants_max;
	public $events_keyword;
	public $events_validation;
	public $events_publication;
	public $events_adresses_id;
	public $events_covoiturage;
	public $events_description;
	public $events_image;
                
	function __construct() {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 1:
                    $event=$args[0];
                    $this->events_id=$event->events_id;
                    $this->events_libelle=$event->events_libelle;
                    $this->events_date_debut=$event->events_date_debut;
                    $this->events_date_fin=$event->events_date_fin;
                    $this->events_nb_participants_max=$event->events_nb_participants_max;
                    $this->events_keyword=$event->events_keyword;
                    $this->events_validation=$event->events_validation;
                    $this->events_publication=$event->events_publication;
                    $this->events_adresses_id=$event->events_adresses_id;
                    $this->events_covoiturage=$event->events_covoiturage;
                    $this->events_description=$event->events_description;
                    $this->events_image=$event->events_image;
                    break;
                case 2:
                    $this->sondages_id="";
                    $this->sondages_libelle=$args[0];
                    $this->sondages_request=$args[1];
                    break;
                case 3:
                    $this->sondages_id=$args[0];
                    $this->sondages_libelle=$args[1];
                    $this->sondages_request=$args[2];
                    break;
                 default:
                    break;
            }
        }
        
        public function getEvents_id() {
            return $this->events_id;
        }

        public function getEvents_libelle() {
            return $this->events_libelle;
        }

        public function getEvents_date_debut() {
            return $this->events_date_debut;
        }

        public function getEvents_date_fin() {
            return $this->events_date_fin;
        }

        public function getEvents_nb_participants_max() {
            return $this->events_nb_participants_max;
        }

        public function getEvents_keyword() {
            return $this->events_keyword;
        }

        public function getEvents_validation() {
            return $this->events_validation;
        }

        public function getEvents_publication() {
            return $this->events_publication;
        }

        public function getEvents_adresses_id() {
            return $this->events_adresses_id;
        }

        public function getEvents_covoiturage() {
            return $this->events_covoiturage;
        }

        public function getEvents_description() {
            return $this->events_description;
        }

        public function getEvents_image() {
            return $this->events_image;
        }

        public function setEvents_id($events_id) {
            $this->events_id = $events_id;
        }

        public function setEvents_libelle($events_libelle) {
            $this->events_libelle = $events_libelle;
        }

        public function setEvents_date_debut($events_date_debut) {
            $this->events_date_debut = $events_date_debut;
        }

        public function setEvents_date_fin($events_date_fin) {
            $this->events_date_fin = $events_date_fin;
        }

        public function setEvents_nb_participants_max($events_nb_participants_max) {
            $this->events_nb_participants_max = $events_nb_participants_max;
        }

        public function setEvents_keyword($events_keyword) {
            $this->events_keyword = $events_keyword;
        }

        public function setEvents_validation($events_validation) {
            $this->events_validation = $events_validation;
        }

        public function setEvents_publication($events_publication) {
            $this->events_publication = $events_publication;
        }

        public function setEvents_adresses_id($events_adresses_id) {
            $this->events_adresses_id = $events_adresses_id;
        }

        public function setEvents_covoiturage($events_covoiturage) {
            $this->events_covoiturage = $events_covoiturage;
        }

        public function setEvents_description($events_description) {
            $this->events_description = $events_description;
        }

        public function setEvents_image($events_image) {
            $this->events_image = $events_image;
        }


}
