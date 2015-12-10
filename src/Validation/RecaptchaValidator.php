<?php
/**
 * ConfigValidator
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Validation;

use Recaptcha\Validation\GlobalValidator;

/**
 * Class used to validate config data given by user in widgets ctp
 */
class RecaptchaValidator extends GlobalValidator
{

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
