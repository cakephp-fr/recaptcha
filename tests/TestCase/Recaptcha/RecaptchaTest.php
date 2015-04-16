<?php
/**
 * RecaptchaTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Test\TestCase\Recaptcha;

use Cake\Network\Http\Client;
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

    public function testVerifyResponse()
    {
        $secret = 'goodSecret';
        // $httpClient = new Client();
        $recaptchaResponse = new RecaptchaResponse();
        $this->Recaptcha = new Recaptcha($recaptchaResponse, $secret);
        // $this->assertEquals(false, $this->Recaptcha->verifyResponse($httpClient, 'good'));
        unset($this->Recaptcha);
    }

    public function testVerifyResponseWrong()
    {
        $secret = 'goodSecret';
        // $httpClient = new Client();
        $recaptchaResponse = new RecaptchaResponse();
        $this->Recaptcha = new Recaptcha($recaptchaResponse, $secret);
        // $this->assertEquals(false, $this->Recaptcha->verifyResponse($httpClient, 'wrong'));
        unset($this->Recaptcha);
    }
}
