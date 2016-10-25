<?php
class FaqBean{
    
        public $faqs_id;
        public $faqs_request;
        public $faqs_answer;
        public $faqs_categorie;
        
	function __construct() {
            $ctp = func_num_args();
            $args = func_get_args();
            switch($ctp)
            {
                case 1://object en parametre
                    $faq=$args[0];
                    $this->faqs_id=$faq->faqs_id;
                    $this->faqs_request=$faq->faqs_request;
                    $this->faqs_answer=$faq->faqs_answer;
                    $this->faqs_categorie=$faq->faqs_categorie;
                case 3:
                    $this->faqs_id="";
                    $this->faqs_request=$args[0];
                    $this->faqs_answer=$args[1];
                    $this->faqs_categorie=$args[2];
                    break;
                case 4:
                    $this->faqs_id=$args[0];
                    $this->faqs_request=$args[1];
                    $this->faqs_answer=$args[2];
                    $this->faqs_categorie=$args[3];
                    break;
                 default:
                    $this->faqs_id="";
                    $this->faqs_request="";
                    $this->faqs_answer="";
                    $this->faqs_categorie="";
                    break;
            }
        }
        
        public function getFaqs_id() {
            return $this->faqs_id;
        }

        public function getFaqs_request() {
            return $this->faqs_request;
        }

        public function getFaqs_answer() {
            return $this->faqs_answer;
        }

        public function getFaqs_categorie() {
            return $this->faqs_categorie;
        }

        public function setFaqs_id($faqs_id) {
            $this->faqs_id = $faqs_id;
        }

        public function setFaqs_request($faqs_request) {
            $this->faqs_request = $faqs_request;
        }

        public function setFaqs_answer($faqs_answer) {
            $this->faqs_answer = $faqs_answer;
        }

        public function setFaqs_categorie($faqs_categorie) {
            $this->faqs_categorie = $faqs_categorie;
        }


}
