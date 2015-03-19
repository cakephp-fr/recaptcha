<?php
/**
 * RecaptchaResponseInterface
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Recaptcha;

/**
 * This class is an interface for the Recaptcha Response
 */
interface RecaptchaResponseInterface
{
    /**
     * Return true/false if Success/Fails
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * Return the Code Errors if any
     *
     * @return string
     */
    public function errorCodes();
    
    /**
     * Sets the success
     *
     * @param bool $success Success
     *
     * @return void
     */
    public function setSuccess($success);

    /**
     * Sets the Code Errors
     *
     * @param string $errorCodes Error Codes
     *
     * @return void
     */
    public function setErrorCodes(array $errorCodes);
}
