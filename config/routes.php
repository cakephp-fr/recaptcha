<?php
use Cake\Routing\Router;

Router::plugin('Recaptcha', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
