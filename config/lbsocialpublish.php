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
            // Facebook
            'facebook' => array(
                'app_id' => '458642664187845',
                'secret' => 'ff2b0aec1b4159e9410b8c24b0ab7362',
                'page_id' => '401532766582915',
                'access_token' => 'AAAGhIhET58UBAK5rlDcLU2MKUZBR6ZBQo2hVyYVZAHnBzMfUIdRtc6mZAtZAmMgPd9980SAzsQS0Ur9n6h9mtTrutA0S3mzPxECANAU9xK7YiXOwBw03r',
            ),
            
            // Twitter
            'twitter' => array(
                'consumer_key' => 'IFUTcLSSeAlAwDqzZWW74A',
                'consumer_secret' => '75Nbt6IYQAqmUWrKBdji8k4BJlI0856op7KPQTRBEI',
                'user_token' => '895009075-oLfL4SFpiX7DeVTxxCpXTJVFXluQNzcIPUIMcKHf',
                'user_secret' => 'C2P3VzNEs8gjjQpADF7J1wYUUHGXLfWYIhXBfS8FZw',
                
                // Twitter > Bitly
                'bitly' => array(
                    'enable' => true,
                    'username' => 'o_1q2k2imlc6',
                    'api_key' => 'R_b7ca5ceb33c7123fd582ba0b309cb990',
                ),
            ),
        ),
    ),
);

// http://developers.facebook.com/tools/explorer
    
/* End of file config/casset.php */
