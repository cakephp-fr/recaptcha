<?php
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;

Configure::config('default', new PhpConfig(dirname(APP) . DS . 'config' . DS));
Configure::load('recaptcha.php', 'default', false);
