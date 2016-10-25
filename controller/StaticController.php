<?php 
class StaticController extends Controller{
	
        function about(){
		$this->render('about');
	}
	function cgu(){
		$this->render('cgu');
	}
	
	function bug(){
		$this->render('bug');
	}
	
	function mentionsLegales(){
		$this->render('mentions-legales');
        }
        
        function contact(){
		$this->render('contact');
	}         
        
        function changeLocale($locale){
            $this->Session->write('locale',$locale);
        }
		function traitement(){
		$this->render('traitement');
	}   
		function traitement_bug(){
		$this->render('traitement_bug');
	}      
	
}