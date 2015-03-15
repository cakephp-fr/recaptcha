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
 * A RecaptchaResponse is returned from checkAnswer().
 */
class RecaptchaResponse //implements RecaptchaResponseInterface
{
    /**
     * @var bool $success
     */
    protected $success;

    /**
     * @var string $errorCodes
     */
    protected $errorCodes;

    /**
     * Return true/false if Success/Fails
     *
     * @return bool
     */
    public function isSuccess() {
        return $this->success;
    }

    /**
     * Return the Code Errors if any
     *
     * @return string
     */
    public function errorCodes() {
        return $this->errorCodes;
    }

    /**
     * Sets the success
     *
     * @param bool $success Success
     *
     * @return void
     */
    public function setSuccess($success) {
        $this->success = $success;
    }

    /**
     * Sets the Code Errors
     *
     * @param string $errorCodes Error Codes
     *
     * @return void
     */
    public function setErrorCodes($errorCodes) {
        $this->errorCodes = $errorCodes;
    }
}
