<?php 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

class ConnexionsController extends Controller{
	
	public $layout    = 'connexion';  // Layout à utiliser pour rendre la vue
	/**
	* Login
	**/
	function index(){
		$this->render('index');
	}

	/**
	* Logout
	**/
	function logout(){
		unset($_SESSION['User']);
		$this->Session->setFlash('Vous ête mainenant déconnecté'); 
		$this->redirect('/'); 
	}
	
	function fbConnect(){
		$this->loadModel('User'); 
		//require 'functions.php';  
		// init app with app id and secret
		FacebookSession::setDefaultApplication(Conf::$fb_id, Conf::$fb_secret);
		// login helper with redirect_uri
		$helper = new FacebookRedirectLoginHelper(Conf::$fb_url_redirect);
		try {
			//$scope=array('email','public_profile');
			// $url=$helper->getReRequestUrl($scope);
		  $session = $helper->getSessionFromRedirect();
		} catch( FacebookRequestException $ex ) {
		  // When Facebook returns an error
		} catch( Exception $ex ) {
		  // When validation fails or other local issues
		}
		// see if we have a session
		if ( isset( $session ) ) {
		  // graph api request for user data
		  
		  $request = new FacebookRequest( $session, 'GET', '/me?fields=id,name,last_name,first_name,email,picture');
		  $me = $request->execute()->getGraphObject('Facebook\GraphUser');
		  
		  // get response
			$fbid = $me->getProperty('id');              // To Get Facebook ID
			$fbfullname = $me->getProperty('name'); // To Get Facebook full name
			$femail = $me->getProperty('email');    // To Get Facebook email ID
			$fid = $me->getProperty('id');    // To Get Facebook email ID
			$fprenom = $me->getProperty('first_name');
			$fnom = $me->getProperty('last_name');
			//photo de profil
			$picture = $me->getProperty('picture')->getProperty('url');
			if(!empty($picture)){
				$fpicture = $me->getProperty('picture')->getProperty('url');
			}else{
				$fpicture = "http://www.google.fr/url?source=imglanding&ct=img&q=https://www.latoilescoute.net/IMG/jpg/facebook-storm-trooper.jpg&sa=X&ei=EahRVe-4CIr8UqmkgNgC&ved=0CAkQ8wc&usg=AFQjCNG9Jk_ILdJs_gfdePmbLeWYq1qgMg";
			}
			
		 /* ---- Session Variables -----*/
			if($this->User->exist_fb($fid)){
				$user=$this->User->findByLoginFb($fid);
				$this->Session->write('User',$user); 
			}else{
				$tab_users=array("users_pseudo"=>$fprenom." ".$fnom,
					"users_nom"=>$fnom,
					"users_prenom"=>$fprenom,
					"users_mail"=>$femail,
					"users_login"=>null,
					"users_login_fb"=>$fid,
					"users_password"=>"",
					"users_photo"=>$fpicture
				);
				$this->User->save($tab_users);
				$user=$this->User->findByLoginFb($fid);
				$this->Session->write('User',$user); 
			}
			$this->redirect('/');
		} else {
		  $this->redirect('/');
		}
	}
}