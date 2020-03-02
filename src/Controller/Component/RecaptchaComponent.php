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
use Cake\Http\Client;
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
     * RecaptchaResponse.
     *
     * @var RecaptchaResponse
     */
    protected $recaptchaResponse;

    /**
     * Recaptcha.
     *
     * @var Recaptcha
     */
    protected $recaptcha;

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
        if (!in_array('Recaptcha.Recaptcha', $controller->viewBuilder()->getHelpers())) {
            $controller->viewBuilder()->setHelpers(['Recaptcha.Recaptcha'], true);
        }
    }

    /**
     * startup callback
     *
     * @param \Cake\Event\Event $event Event.
     *
     * @return void
     */
    public function startup(Event $event)
    {
        $secret = Configure::consume('Recaptcha.secret');
        // throw an exception if the secret is not defined in config/recaptcha.php file
        if (empty($secret)) {
            throw new Exception(__d('recaptcha', "You must set the secret Recaptcha key in config/recaptcha.php file"));
        }

        // instantiate Recaptcha object that deals with retrieving data from google recaptcha
        $this->recaptcha = new Recaptcha(new RecaptchaResponse(), $secret);
        $controller = $event->getSubject();

        $this->setController($controller);
    }

    /**
     * Verify Response
     *
     * @return bool
     */
    public function verify()
    {
        $controller = $this->_registry->getController();
        $gRecaptchaResponse = $controller->getRequest()->getData("g-recaptcha-response");
        if (!empty($gRecaptchaResponse)) {

            $resp = $this->recaptcha->verifyResponse(
                new Client(),
                $gRecaptchaResponse
            );

            // if verification is correct,
            if ($resp) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return an array with errors : missing secret, connexion issue, ...
     *
     * @return array
     */
    public function errors()
    {
        return $this->recaptcha->setErrors();
    }
}
