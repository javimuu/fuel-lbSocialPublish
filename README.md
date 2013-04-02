<h1>Fuel LbSocialPublish</h1>

FuelPHP package for easily post to multiple social networks (Facebook, Twitter, etc.)

<h2>Installation</h2>

### Manual

1. Clone or download the fuel-lbSocialPublish repository
2. Move it in fuel/packages/
3. Edit the config file fuel/packages/lbsocialpublish/config/lbsocialpublish.php
4. Add 'lbsocialpublish' to the 'always_load/packages' array in app/config/config.php (or call `Fuel::add_package('casset')` whenever you want to use it).

If you don't want to change the config file in `fuel/packages/lbsocialpublish/config/lbsocialpublish.php`, you can create your own config file in `fuel/app/config/lbsocialpublish.php`.
And copy the entirely of the original config file.

<h2>Introduction</h2>

<h3>Facebook</h3>

### Configuration

You need to create an Facebook Application here : https://developers.facebook.com/apps
And edit the configuration file

You need a access_token, you can generate here : http://developers.facebook.com/tools/explorer
Select your application, and click on Get access token. Don't forget to check the rights : "publish_actions", "publish_stream", "manage_pages" and "offline_access"

Or, you can use 
```php
\Lb\SocialPublish\Service\FacebookPublish::getToken(); die();
```

In your controller for get your access_token

### Basic usage

```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the facebook publish service
    $facebook = $socialPublish->get('facebook');
    // Populate your post :
    $params = array(
        'message' => 'Message de test !',
        'picture' => 'http://www.informanews.net/imagenews/panasonicTV_Google.jpg',
    );
    $facebook->setParams($params);
    // OR
    $facebook->setMessage('Message de test !');
    $facebook->setPicture('http://www.informanews.net/imagenews/panasonicTV_Google.jpg');

    // And publish !
    $socialPublish->publish();
```

### Complete usage

```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the facebook publish service
    $facebook = $socialPublish->get('facebook');
    // Populate your post :
    $params = array(
        'message' => 'Message de test !',
        'name' => 'Nom de test',
        'caption' => 'Légende de test',
        'link' => 'http://www.google.fr',
        'description' => 'Description de mon message !',
        'picture' => 'http://www.informanews.net/imagenews/panasonicTV_Google.jpg',
        'actions' => array(
            array('name' => "Nom de l'action", 'link' => 'http://www.google.fr/')
        )
    );
    $facebook->setParams($params);

    // And publish !
    $socialPublish->publish();
```

<h3>Twitter</h3>

### Configuration

You need to create Twitter application : https://dev.twitter.com/apps/new
And edit the configuration file

Twitter use Bitly for generate short link, if you want to use Bitly, you need to generate api_key here : http://bitly.com/a/your_api_key
And edit the configuration file

### Basic usage

```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the twitter publish service
    $twitter = $socialPublish->get('twitter');
    $twitter->setMessage('Voici mon tweet !');

    // And publish !
    $socialPublish->publish();
```

## Complete usage

```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the twitter publish service
    $twitter = $socialPublish->get('twitter');
    $twitter->setMessage('Voici mon tweet !');
    // Disable bitly (it's enable by default)
    $twitter->setUseBitly(false);
    // Add hashtags
    $twitter->setHashTags(array('test', 'FuelPHP'));

    // And publish !
    $socialPublish->publish();
```

<h2>Other example</h2>

### Basic publish on Facebook and Twitter
```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the twitter publish service
    $twitter = $socialPublish->get('twitter');
    $twitter->setMessage('Voici mon tweet !');
    
    // Get facebook publish service
    $facebook = $socialPublish->get('facebook');
    $facebook->setMessage('Mon nouveau message !');

    // And publish !
    $socialPublish->publish();
```

### Publish only on twitter

```php
    $socialPublish->publish(array('twitter'));
```

<h2>Add new publish service</h2>

The package is flexible, you can add your own publish service easily.

For example, we wan't to add Google+ publish service :

### Step 1 : Create the Google Service Publish

lbsocialpublish/classes/service/googlepublish.php
```php
<?php

namespace Lb\SocialPublish\Service;

class GooglePublish extends BasePublish implements SocialServiceInterface {

    protected $message;
    
    public function __construct() {

    }
    
    // Setter
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * Publish action
     *
     * @return boolean
     */
    public function publish() {
        // Your code

        return true;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'google';
    }
    
    /**
     * Validation : Need a message
     * 
     * @return boolean
     */
    public function isValid()
    {
        return (!empty($this->message));
    }
    
}
```

For get example, you can look twitterpublish.php or facebookpublish.php files

Note: Don't forget to add your library in vendors folder

### Step 2 : Load your class in the bootstrap

lbsocialpublish/bootstrap.php :
```php
Autoloader::add_classes(array(
                  // Google
	'Lb\\SocialPublish\\Service\\GooglePublish'                => __DIR__.'/classes/service/googlepublish.php',
));
```

### Step 3 : Optionally, you can add your publish service in 'always_load' configuration 

lbsocialpublish/config/lbsocialpublish.php : 
```php
            // Always load
            'always_load' => array(
                'Lb\\SocialPublish\\Service\\FacebookPublish', 
                'Lb\\SocialPublish\\Service\\TwitterPublish',
                // Your Google Publish Service :
                'Lb\\SocialPublish\\Service\\GooglePublish',
            ),
```

Now, you can easily load and use your publish service like : 

```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the google publish service
    $google = $socialPublish->get('google');
    $google->setMessage('My new social publish service !');

    // And publish !
    $socialPublish->publish();
```

If you have not add your publish service class in 'always_load' configuration, you need to follow this instruction :
```php
    // Call the socialpublish manager
    $socialPublish = new Lb\SocialPublish();

    // Get the google publish service
    $google = new Lb\SocialPublish\Service\GooglePublish;
    $google->setMessage('My new social publish service !');

    // Add the service to socialPublish
    $socialPublish->addService($google);

    // And publish !
    $socialPublish->publish();
```