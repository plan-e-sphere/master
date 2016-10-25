<?php 
/**
* Controller
**/
class Controller{
	
	public $request;  				// Objet Request 
	private $vars     = array();	// Variables à passer à la vue
	public $layout    = 'default';  // Layout à utiliser pour rendre la vue
	private $rendered = false;		// Si le rendu a été fait ou pas ?

	/**
	* Constructeur
	* @param $request Objet request de notre application
	**/
	function __construct($request = null){
		$this->Session = new Session(); 
		$this->Form = new Form($this); 
                if(!$this->Session->read('locale')){
                    $this->Session->write('locale','fr');
                }                
		if($request){
			$this->request = $request; 	// On stock la request dans l'instance	
			require ROOT.DS.'config'.DS.'hook.php'; 		
		}
		
	}


	/**
	* Permet de rendre une vue
	* @param $view Fichier à rendre (chemin depuis view ou nom de la vue) 
	**/
	public function render($view){
		if($this->rendered){ return false; }
		extract($this->vars); 
		if(strpos($view,'/')===0){
			$view = ROOT.DS.'view'.$view.'.php';
			$menu = ROOT.DS.'view'.DS.'menu'.$view.'.php';
		}else{
			$menu = ROOT.DS.'view'.DS.'menu'.DS.$this->request->controller.'.php';
			$view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
		}
		//container
		ob_start(); 
		require($view);
		$content_for_layout = ob_get_clean();
		//menu
		if(file_exists($menu)){
			ob_start(); 
			require($menu);
			$menu_for_layout = ob_get_clean();
		}else{
			$menu_for_layout = "";
		}
		require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php'; 
		$this->rendered = true; 
	}

        /**
	* Permet de rendre une vue sans le template
	* @param $view Fichier à rendre (chemin depuis view ou nom de la vue) 
	**/
	public function renderWithoutTemplate($view){
		if($this->rendered){ return false; }
		extract($this->vars); 
		if(strpos($view,'/')===0){
			$view = ROOT.DS.'view'.$view.'.php';
			$menu = ROOT.DS.'view'.DS.'menu'.$view.'.php';
		}else{
			$menu = ROOT.DS.'view'.DS.'menu'.DS.$this->request->controller.'.php';
			$view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
		}
		require($view);
		$this->rendered = true; 
	}

	/**
	* Permet de passer une ou plusieurs variable à la vue
	* @param $key nom de la variable OU tableau de variables
	* @param $value Valeur de la variable
	**/
	public function set($key,$value=null){
		if(is_array($key)){
			$this->vars += $key; 
		}else{
			$this->vars[$key] = $value; 
		}
	}

	/**
	* Permet de charger un model
	**/
	function loadModel($name){
		if(!isset($this->$name)){
			$file = ROOT.DS.'model'.DS.$name.'.php'; 
			require_once($file);
			$this->$name = new $name();
			if(isset($this->Form)){
				$this->$name->Form = $this->Form;  
			}
		}

	}
        
        /**
	* Permet de charger un bean
	**/
	function loadBean($name){
		if(!isset($this->$name)){
			$file = ROOT.DS.'bean'.DS.$name.'.php'; 
			require_once($file);
			$this->$name = new $name();
			if(isset($this->Form)){
				$this->$name->Form = $this->Form;  
			}
		}

	}
        
	/**
	* Permet de gérer les erreurs 404
	**/
	function e404($message){	
		header("HTTP/1.0 404 Not Found");
		$this->set('message',$message); 
		$this->render('/errors/404');
		die();
	}
        
	/**
	* Permet d'appeller un controller depuis une vue
	**/
	function request($controller,$action){
		$controller .= 'Controller';
		require_once ROOT.DS.'controller'.DS.$controller.'.php';
		$c = new $controller();
		return $c->$action(); 
	}


	/**
	* Redirect
	**/
	function redirect($url,$code = null ){
		if($code == 301){
			header("HTTP/1.1 301 Moved Permanently");
		}
		header("Location: ".Router::url($url)); 
	}


}
?>