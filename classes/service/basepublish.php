<?php

namespace Lb\SocialPublish\Service;

class BasePublish{

    public function __construct() {

    }

    /**
     * Permet de définir les paramètres directement depuis un array
     * 
     * @param array $params
     */
    public function setParams(array $params) {
        foreach($params as $key => $value) {
            $function = 'set' . ucfirst($key);
            $this->$function($value);
        }
    }
    
}