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
    protected static $siteVerifyUrl = "https://www.google.com/recaptcha/api/siteverify?";

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var RecaptchaResponse Recaptcha Response.
     */
    protected $recaptchaResponse;

    /**
     * @var string
     */
    protected static $version = "php_1.0";

    /**
     * Constructor.
     *
     * @param RecaptchaResponse Recaptcha Response
     * @param string $secret Shared secret between site and ReCAPTCHA server.
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
     * Encodes the given data into a query string format.
     *
     * @param array $data Array of string elements to be encoded.
     *
     * @return string Encoded request.
     */
    protected function _encodeQS($data)
    {
        $req = "";
        foreach ($data as $key => $value) {
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }

        // Cut the last '&'
        $req = substr($req, 0, strlen($req) - 1);
        return $req;
    }

    /**
     * Submits an HTTP GET to a reCAPTCHA server.
     *
     * @param string $path Url path to recaptcha server.
     * @param array  $data Array of parameters to be sent.
     *
     * @return array response
     */
    protected function _submitHttpGet($path, $data)
    {
        $req = $this->_encodeQS($data);
        $response = file_get_contents($path . $req);
        return $response;
    }

    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param string $remoteIp IP address of end user.
     * @param string $response Response string from recaptcha verification.
     *
     * @return RecaptchaResponse
     */
    public function verifyResponse($remoteIp, $response)
    {
        // Discard empty solution submissions
        if ($response == null || strlen($response) == 0) {
            $recaptchaResponse->setSuccess(false);
            $recaptchaResponse->setErrorCodes('missing-input');
            return $this->recaptchaResponse;
        }

        $getResponse = $this->_submitHttpGet(
            self::$siteVerifyUrl,
            [
                'secret' => $this->secret,
                'remoteip' => $remoteIp,
                'v' => self::$version,
                'response' => $response
            ]
        );
        $answers = json_decode($getResponse, true);

        if (trim($answers['success']) == true) {
            $this->recaptchaResponse->setSuccess(true);
        } else {
            $this->recaptchaResponse->setSuccess(false);
            $this->recaptchaResponse->setErrorCodes($answers['error-codes']);
        }

        return $this->recaptchaResponse;
    }
}
