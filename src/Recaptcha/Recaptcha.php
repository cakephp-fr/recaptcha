<?php
/**
 * This is a PHP library that handles calling reCAPTCHA.
 *    - Documentation and latest version
 *          https://developers.google.com/recaptcha/docs/php
 *    - Get a reCAPTCHA API Key
 *          https://www.google.com/recaptcha/admin/create
 *    - Discussion group
 *          http://groups.google.com/group/recaptcha
 *
 * @copyright Copyright (c) 2014, Google Inc.
 * @link      http://www.google.com/recaptcha
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
/**
 * Recaptcha
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Recaptcha;

use Cake\Http\Client;
use Recaptcha\Recaptcha\Exception\MissingRecaptchaApiKey;
use Recaptcha\Recaptcha\RecaptchaResponse;

/**
 * Recaptcha class
 */
class Recaptcha
{
    /**
     * @var string
     */
    protected static $signupUrl = "https://www.google.com/recaptcha/admin";

    /**
     * @var string
     */
    protected static $siteVerifyUrl = "https://www.google.com/recaptcha/api/siteverify";

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var RecaptchaResponse Recaptcha Response.
     */
    protected $recaptchaResponse;

    /**
     * @var array
     */
    protected $errors;

    /**
     * Constructor.
     *
     * @param RecaptchaResponse $recaptchaResponse Recaptcha Response.
     * @param string $secret Required. The shared key between your site and ReCAPTCHA.
     *
     * @return void
     */
    public function __construct(RecaptchaResponse $recaptchaResponse, $secret)
    {
        $this->recaptchaResponse = $recaptchaResponse;
        if ($secret == null || $secret == "") {
            throw new MissingRecaptchaApiKey([
                'link' => self::$signupUrl,
                'name' => 'here'
            ]);
        }
        $this->secret = $secret;
    }

    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param HttpClientInterface $httpClient Required. HttpClient.
     * @param string $response Required. The user response token provided by the reCAPTCHA to the user and provided to your site on.
     * @param string $remoteIp Optional. The user's IP address.
     *
     * @return bool
     */
    public function verifyResponse(Client $httpClient, $response, $remoteIp = null)
    {
        if (is_null($this->secret)) {
            $this->errors['missing-secret'] = __d('recaptcha', 'secret is null');
            return false;
        }
        // Get Json GRecaptchaResponse Obj from Google server
        $postOptions = [
            'secret' => $this->secret,
            'response' => $response
        ];
        if (!is_null($remoteIp)) {
            $postOptions['remoteip'] = $remoteIp;
        }
        $gRecaptchaResponse = $httpClient->post(self::$siteVerifyUrl, $postOptions);

        // problem while accessing remote
        if (!$gRecaptchaResponse->isOk()) {
            $this->errors['remote-not-accessible'] = __d('recaptcha', 'Remote is not accessible');
            return false;
        }

        $this->recaptchaResponse->setJson($gRecaptchaResponse->getJson());

        if ($this->recaptchaResponse->isSuccess()) {
            return true;
        }
        $this->errors['not-checked'] = __d('recaptcha', 'Recaptcha is not checked');
        return false;
    }

    /**
     * Return an array with errors : missing secret, connexion issue, ...
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}
