<?php
class SondageBean{
    
        public $sondages_id;
        public $sondages_libelle;
        public $sondages_request;
        public $sondages_events_id;
        
	function __construct() {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 0:
                    $this->sondages_id="";
                    $this->sondages_libelle="";
                    $this->sondages_request="";
                    $this->sondages_events_id="";
                    break;
                case 3:
                    $this->sondages_id="";
                    $this->sondages_libelle=$args[0];
                    $this->sondages_request=$args[1];
                    $this->sondages_events_id=$args[2];
                    break;
                case 4:
                    $this->sondages_id=$args[0];
                    $this->sondages_libelle=$args[1];
                    $this->sondages_request=$args[2];
                    $this->sondages_events_id=$args[3];
                    break;
                 default:
                    break;
            }
        }
        
        function getId(){
            return $this->sondages_id;
        }
        
        function getLibelle(){
            return $this->sondages_libelle;
        }
        
        function getRequest(){
            return $this->sondages_request;
        }
        
        function getEventId(){
            return $this->sondages_events_id;
        }
        
        function setId($id){
            $this->sondages_id=$id;
        }
        
        function setLibelle($libelle){
            $this->sondages_libelle=$libelle;
        }
        
        function setRequest($request){
            $this->sondages_request=$request;
        }
        
        function setEventId($event_id){
            $this->sondages_events_id=$event_id;
        }
}
