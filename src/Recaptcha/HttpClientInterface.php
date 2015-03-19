<?php
/**
 * HttpClientInterface
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */

namespace Recaptcha\Recaptcha;

/**
 * Interface For Http Client
 * Implements This interface if you want to use your own Http Client
 */
interface HttpClientInterface
{
    /**
     * Post method
     *
     * @param string $siteVerifyUrl Site Verify Url.
     * @param array $options Options.
     *
     * @return array
     */
    public function post($siteVerifyUrl, array $options);
}
