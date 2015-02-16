<?php
/**
 * RecaptchaComponentTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
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

    public function testStartupWithNonExistingConfigFile()
    {
        Configure::config('default', new PhpConfig(TESTS . DS . 'config' . DS));

        try {
            Configure::load('nonExistingFile', 'default', false);
            //Cake\Core\Exception\Exception: Could not load configuration file: /Users/cake17/sites/dev/cakephp-recaptcha/config/nonExistingFile.php
        }

        catch (\Cake\Core\Exception\Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testStartupWithExistingConfigFile()
    {
        Configure::config('default', new PhpConfig(TESTS . DS . 'config' . DS));
        Configure::load('recaptchaWithExistingKeys', 'default', false);

        // check that configs are well imported
        $this->assertEquals('goodkey', Configure::read('Recaptcha.siteKey'));
        $this->assertEquals('goodsecret', Configure::read('Recaptcha.secret'));
        $this->assertEquals('en', Configure::read('Recaptcha.defaultLang'));
        $this->assertEquals('light', Configure::read('Recaptcha.defaultTheme'));
        $this->assertEquals('image', Configure::read('Recaptcha.defaultType'));

        // test that startup returns void
        //$this->Recaptcha->startup();
    }

    public function testStartupWithEmptyOptions()
    {
        Configure::config('default', new PhpConfig(TESTS . DS . 'config' . DS));
        Configure::load('recaptchaWithEmptyOptions', 'default', false);

        $this->assertEquals('goodkey', Configure::read('Recaptcha.siteKey'));
        $this->assertEquals('goodsecret', Configure::read('Recaptcha.secret'));
        $this->assertEquals('', Configure::read('Recaptcha.defaultLang'));
        $this->assertEquals('', Configure::read('Recaptcha.defaultTheme'));
        $this->assertEquals('', Configure::read('Recaptcha.defaultType'));
    }
}
