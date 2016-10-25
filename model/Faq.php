<?php
class Faq extends Model{
	public $primaryKey = 'faqs_id';
	
        function getCategories(){
            $categorie=$this->find(array(
                                'distinct'   => '',
				'fields'     => 'Faq.faqs_categorie'
			));
            return $categorie;
        }
        
        function getFaqs(){
            $faqs=$this->find(array(
                'fields'     => 'Faq.faqs_id, Faq.faqs_request, Faq.faqs_answer, Faq.faqs_categorie',
              ));
             return $faqs;
        }
        
        function getFaqsById($id){
		$faqs=$this->findFirst(array(
				'fields'     => 'Faq.*',
				'conditions' => array('Faq.faqs_id'=>$id),
			));
                return $faqs;
	}
	
	function getFaqsByCategorie($categorie){
            $faqs=$this->find(array(
                'fields'     => 'Faq.*',
                'conditions' => 'Faq.faqs_categorie ="'.$categorie.'"'
              ));
            
             return $faqs;
        }
}