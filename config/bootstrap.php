<?php
/**
 * Bootstrap
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Recaptcha\Validation\ConfigValidator;

// Pass the config data from config/recaptcha.php to Configure Class
// If the file does not exist, an exception is thrown
Configure::config('default', new PhpConfig(dirname(APP) . DS . 'config' . DS));
Configure::load('recaptcha', 'default', false);

// Validate the Configure Data
$validator = new ConfigValidator();

$errors = $validator->errors(Configure::read('Recaptcha'));

if (!empty($errors)) {
    throw new \Exception(__d('recaptcha', 'One of your recaptcha config value is incorrect'));
    // throw an exception with config error that is raised
}
