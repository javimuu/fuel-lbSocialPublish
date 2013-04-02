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

Autoloader::add_core_namespace('LbSocialPublish');

Autoloader::add_classes(array(
	'Lb\\SocialPublish'                => __DIR__.'/classes/socialpublish.php',
	'Lb\\SocialPublish\\Service\\SocialServiceInterface'                => __DIR__.'/classes/service/socialserviceinterface.php',
	'Lb\\SocialPublish\\Service\\BasePublish'                => __DIR__.'/classes/service/basepublish.php',
    
                  // Facebook
	'Lb\\SocialPublish\\Service\\FacebookPublish'                => __DIR__.'/classes/service/facebookpublish.php',
	'Facebook'                => __DIR__.'/vendors/facebook-php-sdk/src/facebook.php',
    
                  // Twitter
	'Lb\\SocialPublish\\Service\\TwitterPublish'                => __DIR__.'/classes/service/twitterpublish.php',
	'tmhOAuth'                => __DIR__.'/vendors/tmhOAuth/tmhOAuth.php',
));

\Config::load('lbsocialpublish');
/* End of file bootstrap.php */
