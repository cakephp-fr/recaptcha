<?php
/**
 * RecaptchaComponentTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 *
 */
namespace Recaptcha\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\TestSuite\TestCase;
use Recaptcha\Controller\Component\RecaptchaComponent;
use Recaptcha\Recaptcha\Recaptcha;

/**
 * Recaptcha\Controller\Component\RecaptchaComponent Test Case
 */
class RecaptchaComponentTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Recaptcha = new RecaptchaComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recaptcha);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test StartupWithExistingConfigFile
     *
     * @return void
     */
    public function testStartupWithExistingConfigFile()
    {
        Configure::config('default', new PhpConfig(PATH_TO_CONFIG_FILES));
        Configure::load('recaptchaWithExistingKeys', 'default', false);

        // check that secret is well imported
        $this->assertEquals('goodsecret', Configure::read('Recaptcha.secret'));
    }

    /**
     * testVerifyPostRecaptcha
     *
     * @return void
     */
    public function testVerifyPostRecaptcha()
    {
        $stub = $this->getMockBuilder('Recaptcha')
                     ->disableOriginalConstructor()
                     ->getMock();

        // Configure the stub.
        $stub->method('verifyResponse')
             ->willReturn('null');

        // $this->Recaptcha->verifyPostRecaptcha($controller, $stub->verifyResponse());
        $this->assertEquals(null, $stub->verifyResponse());
    }
}
