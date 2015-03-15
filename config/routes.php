<?php
/**
 * Routes for Recaptcha Plugin
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
use Cake\Routing\Router;

Router::plugin('Recaptcha', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
