<?php
/**
 * Recaptcha Component
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
 */
namespace Recaptcha\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;
use Recaptcha\Lib\ReCaptcha;

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
        $controller->helpers[] = 'Recaptcha.Recaptcha';
        // Set config from config/recaptcha.php
        $this->config(Configure::read('Recaptcha'));
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
        $controller = $event->subject();
        // get host
        $host = $controller->request->env("REMOTE_ADDR");

        // The response from reCAPTCHA
        $resp = null;
        // The error code from reCAPTCHA, if any
        $error = null;
        $reCaptcha = new ReCaptcha($this->config('secret'));
        // unset secret from config
        $this->config('secret', '');

        // send siteKey, lang, theme and type from config to helper
        // $controller->helpers['Recaptcha.Recaptcha'] = $this->config();
        // $controller->helpers['Recaptcha.Recaptcha']['siteKey'] = $this->config('siteKey');
        // $controller->helpers['Recaptcha.Recaptcha']['lang'] = $this->config('defaultLang');
        // $controller->helpers['Recaptcha.Recaptcha']['theme'] = $this->config('defaultTheme');
        // $controller->helpers['Recaptcha.Recaptcha']['type'] = $this->config('defaultType');

        if ($controller->request->is(['post', 'put', 'patch'])) {
            // if Recaptcha is not checked
            if (isset($controller->request->data["g-recaptcha-response"]) && empty($controller->request->data["g-recaptcha-response"])) {
                $controller->Flash->error(__d('recaptcha', 'Please check Recaptcha Box.'));
                return $controller->redirect($controller->referer());
            }

            if (isset($controller->request->data["g-recaptcha-response"]) && !empty($controller->request->data["g-recaptcha-response"])) {
                $gRecaptchaResponse = $controller->request->data["g-recaptcha-response"];
                $resp = $reCaptcha->verifyResponse(
                    $host,
                    $gRecaptchaResponse
                );
                // if verification is incorrect,
                if ($resp != null && !$resp->success) {
                    $controller->Flash->error(__d('recaptcha', 'Please check Recaptcha Box.'));
                    return $controller->redirect($controller->referer());
                }
            }
        }
    }
}
