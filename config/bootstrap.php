<?php
/**
 * Bootstrap
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
use Cake\Core\Configure;
use Recaptcha\Validation\ConfigValidator;

$config = Configure::read('Recaptcha');
if ($config == null) {
    throw new \Exception(__d('recaptcha', 'Please add a configuration for the Recaptcha plugin in the app.php file'));
}

// Validate the Configure Data
$validator = new ConfigValidator();

$errors = $validator->errors(Configure::read('Recaptcha'));

if (!empty($errors)) {
    $errMsg = '';
    $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($errors));
    foreach($it as $v) {
      $errMsg .= "- " . $v . "<br/> ";
    }
    throw new \Exception(__d('recaptcha', 'One of your recaptcha config value is incorrect: <br />' . $errMsg));
}
