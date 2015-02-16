<?php
/**
 * ReCaptchaTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
 */
namespace Recaptcha\Test\TestCase\Lib;

use Cake\TestSuite\TestCase;
use Recaptcha\Lib\ReCaptcha;

/**
 * Recaptcha\Lib\ReCaptcha Test Case
 */
class ReCaptchaTest extends TestCase
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
        $this->ReCaptcha = new ReCaptcha($secret);
        //$this->assertEquals();
        unset($this->ReCaptcha);
    }

    public function testWithExistingSecret()
    {
        $secret = 'goodSecret';
        $this->ReCaptcha = new ReCaptcha($secret);
        //$this->assertEquals();
        unset($this->ReCaptcha);
    }
}
