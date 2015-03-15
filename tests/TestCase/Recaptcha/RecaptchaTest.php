<?php
/**
 * RecaptchaTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 *
 */
namespace Recaptcha\Test\TestCase\Lib;

use Cake\TestSuite\TestCase;
use Recaptcha\Recaptcha\Recaptcha;
use Recaptcha\Recaptcha\RecaptchaResponse;

/**
 * Recaptcha\Recaptcha\Recaptcha Test Case
 */
class RecaptchaTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    public function testWithNonExistingSecret()
    {
        $secret = 'wrongSecret';
        $recaptchaResponse = new RecaptchaResponse();
        $this->Recaptcha = new Recaptcha($recaptchaResponse, $secret);
        //$this->assertEquals();
        unset($this->Recaptcha);
    }

    public function testWithExistingSecret()
    {
        $secret = 'goodSecret';
        $recaptchaResponse = new RecaptchaResponse();
        $this->Recaptcha = new Recaptcha($recaptchaResponse, $secret);
        //$this->assertEquals();
        unset($this->Recaptcha);
    }
}
