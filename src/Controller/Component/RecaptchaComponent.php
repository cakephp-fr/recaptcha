<?php
/**
 * Recaptcha Component
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\Event;
use Exception;
use Recaptcha\Recaptcha\Recaptcha;
use Recaptcha\Recaptcha\RecaptchaResponse;

class RecaptchaComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Initialize config data and properties.
     *
     * @param array $config The config data.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        // Get controller obj
        $controller = $this->_registry->getController();
        // Add the helper on the fly
        if (!isset($controller->helpers['Recaptcha.Recaptcha'])) {
            $controller->helpers[] = 'Recaptcha.Recaptcha';
        }
        // Set config from config/recaptcha.php
        $this->config(Configure::read('Recaptcha'));

        // throw an exception if the private key is not defined in config/recaptcha.php file
        if (empty($this->config('secret'))) {
            throw new Exception(__d('recaptcha', "You must set your private Recaptcha key in config/recaptcha.php file"));
        }
    }

    /**
     * startup callback
     *
     * @param \Cake\Event\Event $event Event.
     *
     * @return mix void
     */
    public function startup(Event $event)
    {
        $response = new RecaptchaResponse();
        // instantiate Recaptcha object that deals with retrieving data from google recaptcha
        $recaptcha = new Recaptcha($response, $this->config('secret'));
        // unset secret from config
        $this->config('secret', '');

        if ($event->subject()->request->is(['post', 'put', 'patch'])) {
            if (isset($controller->request->data["g-recaptcha-response"]) && !empty($controller->request->data["g-recaptcha-response"])) {

                $gRecaptchaResponse = $controller->request->data["g-recaptcha-response"];
                $host = $controller->request->env("REMOTE_ADDR");

                $resp = $recaptcha->verifyResponse(
                    $host,
                    $gRecaptchaResponse
                );
                // if verification is incorrect,
                if ($resp != null && !$resp->success) {

                    //$controller->Flash->error(__d('recaptcha', 'Please check Recaptcha Box.'));
                    return false;
                }
            }
        }
    }

    /**
     * Verify the Recaptcha Response
     *
     * @param Event $event
     * @param Recaptcha $recaptcha
     *
     * @return bool
     */
    // public function verify(Event $event, Recaptcha $recaptcha)
    // {
    //     $controller = $event->subject();
    //
    //     // if Recaptcha is not checked
    //     if (isset($controller->request->data["g-recaptcha-response"]) && empty($controller->request->data["g-recaptcha-response"])) {
    //         $controller->Flash->error(__d('recaptcha', 'Please check Recaptcha Box.'));
    //         return false;
    //     }
    //
    //
    //     // The response from recaptcha
    //     $resp = null;
    //     // The error code from recaptcha, if any
    //     $error = null;
    //
    //     if (isset($controller->request->data["g-recaptcha-response"]) && !empty($controller->request->data["g-recaptcha-response"])) {
    //         $gRecaptchaResponse = $controller->request->data["g-recaptcha-response"];
    //         $resp = $recaptcha->verifyResponse(
    //             $host,
    //             $gRecaptchaResponse
    //         );
    //         // if verification is incorrect,
    //         if ($resp != null && !$resp->success) {
    //             $controller->Flash->error(__d('recaptcha', 'Please check Recaptcha Box.'));
    //             return false;
    //         }
    //     }
    // }
}
