<?php
/**
 * MissingRecaptchaApiKey Exception
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
 */
namespace Recaptcha\Lib\Exception;

use Cake\Core\Exception\Exception;

/**
 * Exception raised when an api key is not provided in recaptcha config file.
 *
 */
class MissingRecaptchaApiKey extends Exception
{
    protected $_messageTemplate = 'The api key for reCAPTCHA could not be found. You must register one <a href="%s">%s</a>';
}
