<?php

/**
 * LbSocialPublish : Publish post on social networks (facebook, twitter)
 *
 * @package    LbSocialPublish
 * @version    v1.00
 * @author     Julien Huriez
 * @license    MIT License
 * @copyright  2013 Julien Huriez
 * @link   https://github.com/jhuriez/fuel-lbSocialPublish
 */

return array(
    'lb' => array(
        'socialpublish' => array(
            // Always load
            'always_load' => array(
                'Lb\\SocialPublish\\Service\\FacebookPublish', 
                'Lb\\SocialPublish\\Service\\TwitterPublish'
            ),
            
            // Facebook
            'facebook' => array(
                'app_id' => 'YOUR_APP_ID',
                'secret' => 'YOUR_APP_SECRET',
                'page_id' => 'YOUR_PAGE_ID',
                'access_token' => 'YOUR_ACCESS_TOKEN',
            ),
            
            // Twitter
            'twitter' => array(
                'consumer_key' => 'YOUR_CONSUMER_KEY',
                'consumer_secret' => 'YOUR_CONSUMER_SECRET',
                'user_token' => 'YOUR_USER_TOKEN',
                'user_secret' => 'YOUR_USER_SECRET',
                
                // Twitter > Bitly
                'bitly' => array(
                    'enable' => true,
                    'username' => 'YOUR_USERNAMER',
                    'api_key' => 'YOUR_API_KEY',
                ),
            ),
        ),
    ),
);

/* End of file config/casset.php */
