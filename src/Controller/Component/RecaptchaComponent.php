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
     * Attach Recaptcha helper to Controller.
     *
     * @param Controller $controller Controller.
     *
     * @return void
     */
    public function setController($controller)
    {
        // Add the helper on the fly
        if (!isset($controller->helpers['Recaptcha.Recaptcha'])) {
            $controller->helpers[] = 'Recaptcha.Recaptcha';
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
        $secret = Configure::read('Recaptcha.secret');
        // throw an exception if the secret is not defined in config/recaptcha.php file
        if (empty($secret)) {
            throw new Exception(__d('recaptcha', "You must set your private Recaptcha key in config/recaptcha.php file"));
        }
        $response = new RecaptchaResponse();
        // instantiate Recaptcha object that deals with retrieving data from google recaptcha
        $recaptcha = new Recaptcha($response, $secret);

        $this->setController($event->subject());

        $this->verifyPostRecaptcha($event->subject(), $recaptcha);
    }

    /**
     * Verify Recaptcha Response if POST['g-recaptcha-response'] exists.
     *
     * @param Recaptcha $recaptcha Recaptcha.
     * @param Controller $controller Controller.
     *
     * @return mix void
     */
    public function verifyPostRecaptcha($controller, Recaptcha $recaptcha)
    {
        if ($controller->request->is(['post', 'put', 'patch'])) {
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
}
