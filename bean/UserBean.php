<?php
class UserBean{
    
        public $users_id;
        public $users_statut;
        public $users_nom;
        public $users_prenom;
        public $users_mail;
        public $users_pseudo;
        public $users_login;
        public $users_login_fb;
        public $users_password;
        public $users_photo;
        
	function __construct() {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 1://object en parametre
                    $user=$args[0];
                    $this->users_id=$user->users_id;
                    $this->users_statut=$user->users_statut;
                    $this->users_nom=$user->users_nom;
                    $this->users_prenom=$user->users_prenom;
                    $this->users_mail=$user->users_mail;
                    $this->users_pseudo=$user->users_pseudo;
                    $this->users_login=$user->users_login;
                    $this->users_login_fb=$user->users_login_fb;
                    $this->users_password=$user->users_password;
                    $this->users_photo=$user->users_photo;
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
                
        public function getUsers_id() {
            return $this->users_id;
        }

        public function getUsers_statut() {
            return $this->users_statut;
        }

        public function getUsers_nom() {
            return $this->users_nom;
        }

        public function getUsers_prenom() {
            return $this->users_prenom;
        }

        public function getUsers_mail() {
            return $this->users_mail;
        }

        public function getUsers_pseudo() {
            return $this->users_pseudo;
        }

        public function getUsers_login() {
            return $this->users_login;
        }

        public function getUsers_login_fb() {
            return $this->users_login_fb;
        }

        public function getUsers_password() {
            return $this->users_password;
        }

        public function getUsers_photo() {
            return $this->users_photo;
        }

        public function setUsers_id($users_id) {
            $this->users_id = $users_id;
        }

        public function setUsers_statut($users_statut) {
            $this->users_statut = $users_statut;
        }

        public function setUsers_nom($users_nom) {
            $this->users_nom = $users_nom;
        }

        public function setUsers_prenom($users_prenom) {
            $this->users_prenom = $users_prenom;
        }

        public function setUsers_mail($users_mail) {
            $this->users_mail = $users_mail;
        }

        public function setUsers_pseudo($users_pseudo) {
            $this->users_pseudo = $users_pseudo;
        }

        public function setUsers_login($users_login) {
            $this->users_login = $users_login;
        }

        public function setUsers_login_fb($users_login_fb) {
            $this->users_login_fb = $users_login_fb;
        }

        public function setUsers_password($users_password) {
            $this->users_password = $users_password;
        }

        public function setUsers_photo($users_photo) {
            $this->users_photo = $users_photo;
        }
}
