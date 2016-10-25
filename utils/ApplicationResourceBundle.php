<?php
class ApplicationResourceBundle {
    public static function getConstant($varName, $locale, $args=null){
        require_once ROOT.DS.'ressources'.DS.$locale.'.php';
        if($args!=null){
            $message=self::formatMessage(constant($varName),$args);
        }else{
            $message=constant($varName);
        }
        return $message;
    }
    
    static function formatMessage($message, $args){
        foreach ($args as $key => $value) {
            $message = str_replace("{{$key}}",$value,$message);
        }
        return $message;
    }
}

