<?php
class Conf{
	
	static $debug = 1; 
	
	static $fb_id='517987701707524';
	
	static $fb_secret='1321b15956015b0ee48970f9b2c14a76';
	
	static $fb_url_redirect='http://plan-e-sphere.fr/connexions/fbConnect';
	
	static $base_url='http://plan-e-sphere.fr';
	
	static $databases = array(

		'default' => array(
			'host'		=> 'localhost',
			'database'	=> 'juntos_dev',
			'login'		=> 'root',
			'password'	=> 'juntos'
		)
	);
        
        static $language = array("fr"=>"French", "en"=>"English", "es"=>"Spanish", "jp"=>"Japan");

}

Router::prefix('cockpit','admin');


Router::connect('','events/index');
Router::connect('connexion','connexions/index');
Router::connect('myProfile','users/monProfil');
Router::connect('cockpit','cockpit/posts/index');
Router::connect('about','static/about');
Router::connect('cgu','static/cgu');
Router::connect('aide','static/aide');
Router::connect('mentions-legales','static/mentionsLegales');
Router::connect('faq','faqs/index');
Router::connect('contact','static/contact');
Router::connect('traitement','static/traitement');
Router::connect('bug','static/bug');
Router::connect('traitement_bug','static/traitement_bug');


Router::connect('page/:slug-:id','pages/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/category/:slug','posts/category/slug:([a-z0-9\-]+)');
Router::connect('blog/*','posts/*');
