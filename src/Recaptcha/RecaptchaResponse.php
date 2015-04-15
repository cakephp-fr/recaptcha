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
 * RecaptchaResponse
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Recaptcha;

use Recaptcha\Recaptcha\RecaptchaResponseInterface;

/**
 * A RecaptchaResponse returned by Google Server.
 */
class RecaptchaResponse implements RecaptchaResponseInterface
{
    /**
     * @var bool $success
     */
    protected $success;

    /**
     * @var array $errorCodes
     */
    protected $errorCodes;

    /**
     * @var array $errorCodesAvailable All error codes that google server may respond
     */
    protected static $errorCodesAuthorized = [
        'missing-input-secret' => 'The secret parameter is missing.',
        'invalid-input-secret' => 'The secret parameter is invalid or malformed.',
        'missing-input-response' => 'The response parameter is missing.',
        'invalid-input-response' => 'The response parameter is invalid or malformed.'
    ];

    /**
     * Return true/false if Success/Fails.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * Return the Code Errors if any.
     *
     * @return array
     */
    public function errorCodes()
    {
        return $this->errorCodes;
    }

    /**
     * Sets the success.
     *
     * @param bool $success Success.
     *
     * @return void
     */
    public function setSuccess($success)
    {
        if ($this->_validateSuccess($success)) {
            $this->success = $success;
        }
    }

    /**
     * Validates the success
     * Only if success is a boolean.
     *
     * @param bool $success Success.
     *
     * @return bool
     */
    protected function _validateSuccess($success)
    {
        if (is_bool($success)) {
            return true;
        }
        return false;
    }

    /**
     * Sets the Code Errors.
     *
     * @param array $errorCodes Error Codes.
     *
     * @return void
     */
    public function setErrorCodes(array $errorCodes)
    {
        if ($this->_validateErrorCodes($errorCodes)) {
            $this->errorCodes = $this->_purifyErrorCodes($errorCodes);
        }
    }

    /**
     * Validates the errorCodes
     * Only if errorCodes is an array and is in available errorCodes.
     *
     * @param array $errorCodes Error Codes.
     *
     * @return bool
     */
    protected function _validateErrorCodes(array $errorCodes)
    {
        if (empty($errorCodes)) {
            return false;
        }
        if (!is_array($errorCodes)) {
            return false;
        }

        return true;
    }

    /**
     * Return a array with only the authorized errorCodes.
     *
     * @param array $errorCodes Error Codes.
     * @return array
     */
    protected function _purifyErrorCodes(array $errorCodes)
    {
        $errorCodesPurified = [];
        foreach ($errorCodes as $num => $errorCode) {
            if (key_exists($errorCode, self::$errorCodesAuthorized)) {
                $errorCodesPurified[$num] = $errorCode;
            }
        }
        return $errorCodesPurified;
    }

    /**
     * Hydrate the Object with $json data.
     *
     * @param array $json Json response of GRecaptcha server.
     *
     * @return void
     */
    public function setJson(array $json)
    {
        if (isset($json['error-codes']) && !empty($json['error-codes'])) {
            $this->setErrorCodes($json['error-codes']);
        }
        if (isset($json['success']) && !empty($json['success'])) {
            $this->setSuccess($json['success']);
        }
    }
}
