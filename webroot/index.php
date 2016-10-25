<?php
$debut = microtime(true); 
setlocale (LC_TIME, 'fr_FR.utf8','fra');
define('ENV','EXT');
define('WEBROOT',dirname(__FILE__)); 
define('ROOT',dirname(WEBROOT)); 
define('DS',DIRECTORY_SEPARATOR);
define('CORE',ROOT.DS.'core');

require CORE.DS.'includes.php';

if(ENV=='EXT'){
	define('BASE_URL',Conf::$base_url);
} else{
	define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME']))); 
}
define('CSS',str_replace('\\','/',BASE_URL.DS.'webroot'.DS.'css'));
define('JS',str_replace('\\','/',BASE_URL.DS.'webroot'.DS.'js'));
define('FONT',str_replace('\\','/',BASE_URL.DS.'webroot'.DS.'fonts'));
define('IMG',str_replace('\\','/',BASE_URL.DS.'webroot'.DS.'img'));
define('MEDIA',str_replace('\\','/',BASE_URL.DS.'webroot'.DS.'media'));
define('FACEBOOK_SDK_V4_SRC_DIR',__DIR__ .DS.'apiFacebook/src/Facebook/');
require __DIR__ .DS.'apiFacebook/autoload.php';
new Dispatcher();
?>
