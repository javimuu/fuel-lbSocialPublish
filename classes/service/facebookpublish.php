<?php

namespace Lb\SocialPublish\Service;

class FacebookPublish extends BasePublish implements SocialServiceInterface {

    protected $message;
    protected $name;
    protected $caption;
    protected $link;
    protected $description;
    protected $picture;
    protected $actions;

    // Setter
    public function __construct() {
        parent::__construct();
        $this->actions = array();
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setCaption($caption) {
        $this->caption = $caption;
        return $this;
    }

    public function setLink($link) {
        $this->link = $link;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setPicture($picture) {
        $this->picture = $picture;
        return $this;
    }

    public function setActions($actions) {
        $this->actions = $actions;
        return $this;
    }

    /**
     * Publication sur facebook
     * 
     * @return boolean
     */
    public function publish() {
        $params = array(
            'message' => $this->message,
            'name' => $this->name,
            'caption' => $this->caption,
            'description' => $this->description,
        );
        if (!empty($this->link)) {
            $params['link'] = $this->link;
        }
        if (!empty($this->picture)) {
            $params['picture'] = $this->picture;
        }
        if (!empty($this->actions)) {
            $params['actions'] = $this->actions;
        }

        $appConfig = array(
            'appId' => \Config::get('lb.socialpublish.facebook.app_id'),
            'secret' => \Config::get('lb.socialpublish.facebook.secret'),
        );

        $accessToken = \Config::get('lb.socialpublish.facebook.access_token');
        $pageId = \Config::get('lb.socialpublish.facebook.page_id');

        $facebook = new \Facebook($appConfig);
        $params['access_token'] = $accessToken;

        return $facebook->api('/' . $pageId . '/feed', 'post', $params);
    }

    
    public static function getToken() {
        $appConfig = array(
            'appId' => \Config::get('lb.socialpublish.facebook.app_id'),
            'secret' => \Config::get('lb.socialpublish.facebook.secret'),
            'cookie' => true,
        );

        $facebook = new \Facebook($appConfig);
        /* on récupère les informations de l'utilisateur connecté à Facebook */
        $user = $facebook->getUser();

        /* si connecté */
        if ($user) {
            try {
                $accounts = $facebook->api('/me/accounts');
                echo '<pre>';
                print_r($accounts); /* on affiche les informations retournées */
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }

        if ($user) {
            $logoutUrl = $facebook->getLogoutUrl();
            echo '<a href="' . $logoutUrl . '">Log Out</a>';
        } else {
            $login_params = array(
                'scope' => 'manage_pages,publish_stream,offline_access' /* paramètres permettant de récupérer le token, offline_access permet d'utiliser le token même si vous n'êtes pas connecté directement (ex. : avec un cron) */
            );
            $loginUrl = $facebook->getLoginUrl($login_params);
            echo '<a href="' . $loginUrl . '">Login</a>';
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return 'facebook';
    }

    /**
     * Validation : La publication doit contenir au minimum un message
     * 
     * @return boolean
     */
    public function isValid() {
        return (!empty($this->message));
    }

}