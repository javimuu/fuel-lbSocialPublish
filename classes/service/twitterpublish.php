<?php

namespace Lb\SocialPublish\Service;

class TwitterPublish extends BasePublish implements SocialServiceInterface {

    protected $message;
    protected $hashTags;
    protected $useBitly;
    
    public function __construct() {
        $this->hashTags = array();
        $this->useBitly = true;
    }
    
    // Setter
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setHashTags($hashTags) {
        $this->hashTags = $hashTags;
        return $this;
    }
    
    public function setUseBitly($useBitly) {
        $this->useBitly = $useBitly;
        return $this;
    }
    
    /**
     * Permet de publier un Tweet
     * 
     * @TODO: Image ?
     * 
     * @return boolean
     */
    public function publish() {
        // Bitly raccourci pour les URLs
        if (\Config::get('lb.socialpublish.twitter.bitly.enable') == true && $this->useBitly) {
            $bitlyUsername = \Config::get('lb.socialpublish.twitter.bitly.username');
            $bitlyApiKey = \Config::get('lb.socialpublish.twitter.bitly.api_key');

            // Detect link in the message
            $pattern = '#https?://(?:\w|[/.-])*#';
            $result = array();
            @preg_match_all($pattern, $this->message, $result);

            $links = $result[0];
            $countLinks = @count($links);

            // Replace links with bitly links
            for ($j = 0; $j <= $countLinks - 1; $j++) {
                $linkShorted = $this->makeBitlyUrl($links[$j], $bitlyUsername, $bitlyApiKey);
                $this->message = str_replace($links[$j], $linkShorted, $this->message);
            }
        }

        // Add hashtags
        foreach($this->hashTags as $hashTag)
        {
            $this->message .= ($hashTag[0] == '#') ? ' ' : ' #';
            $this->message .= $hashTag;
        }
        
        // Troncate the message with 140 characters (twitter limit)
        $this->message = $this->troncate($this->message);

        // send OAuth request
        $tmhOAuth = new \tmhOAuth(array(
                    'consumer_key' => \Config::get('lb.socialpublish.twitter.consumer_key'),
                    'consumer_secret' => \Config::get('lb.socialpublish.twitter.consumer_secret'),
                    'user_token' => \Config::get('lb.socialpublish.twitter.user_token'),
                    'user_secret' => \Config::get('lb.socialpublish.twitter.user_secret'),
                ));

        $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
            'status' => $this->message
                ));

        return ($code == 200);
    }
    

    /**
     * Raccourci un URL grâce à l'API Bit.ly
     * 
     * @param string $url
     * @param string $login
     * @param string $appkey
     * @param string $format
     * @return string
     */
    public function makeBitlyUrl($url, $login, $appkey, $format = 'txt') {
        $connectURL = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode($url) . '&format=' . $format;
        return $this->curl_get_result($connectURL);
    }

    /**
     * Tronquer une chaine de caractère trop longue
     * 
     * @param string $message
     * @param integer $maxLength
     * @return string
     */
    public function troncate($message, $maxLength = 140) {
        if (strlen($message) > $maxLength) {
            $message = substr($message, 0, $maxLength);
            $last_space = strrpos($message, " ");
            $message = substr($message, 0, $last_space) . "...";
        }
        
        return $message;
    }

    public function curl_get_result($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'twitter';
    }
    
    /**
     * Validation : Un tweet doit contenir au minimum un message
     * 
     * @return boolean
     */
    public function isValid()
    {
        return (!empty($this->message));
    }
    
}