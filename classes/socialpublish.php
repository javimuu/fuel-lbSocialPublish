<?php

/**
 * LbSocialPublish : Publish post on social networks (facebook, twitter)
 *
 * @package    LbSocialPublish
 * @version    v1.00
 * @author     Julien Huriez
 * @license    MIT License
 * @copyright  2013 Julien Huriez
 * @link   
 */

namespace Lb;

class SocialPublish {

    protected $services = array();
    protected $servicesName = array();

    public function __construct($services) {
        foreach ($services as $service) {
            $this->addService($service);
        }
    }

    /**
     * Ajoute un service de type social (facebook, twitter, etc..)
     * 
     * @param Social Service $service
     */
    public function addService($service) {
        $this->services[$service->getName()] = $service;
        $this->servicesName[] = $service->getName();
    }

    /**
     * Permet d'obtenir le social service (ex: facebook, twitter)
     * 
     * @param SocialService $service
     * @return SocialService|boolean
     */
    public function get($service) {
        if (in_array($service, $this->servicesName)) {
            return $this->services[$service];
        } else {
            return false;
        }
    }

    /**
     * Permet de publier sur plusieurs réseaux sociaux selon les $services
     * Si $services non spécifié, alors on publie sur tous les réseaux sociaux disponibles
     * 
     * @param array $params 
     * @return boolean
     */
    public function publish($services = array()) {
        $res = true;

        // Si tous les réseaux sociaux
        if (empty($services)) {
            foreach ($this->servicesName as $serviceName) {
                if ($this->services[$serviceName]->isValid()) {
                    $_res = $this->services[$serviceName]->publish();
                    $res = ($res) ? $_res : false;
                } else {
                    $res = false;
                }
            }
        }
        // Sinon on parcours les $services spécifiés
        else {
            foreach ($services as $serviceName) {
                if (!in_array($serviceName, $this->servicesName)) {
                    throw new SocialPublish_Exception('Le social service "' . $serviceName . '" n\'existe pas.');
                }

                if (!$this->services[$serviceName]->isValid()) {
                    throw new SocialPublish_Exception('Le social service "' . $serviceName . '" n\'est pas valide.');
                }

                $_res = $this->services[$serviceName]->publish();
                $res = ($res) ? $_res : false;
            }
        }
        return $res;
    }

}

class SocialPublish_Exception extends \FuelException {
    
}

/* End of file casset.php */