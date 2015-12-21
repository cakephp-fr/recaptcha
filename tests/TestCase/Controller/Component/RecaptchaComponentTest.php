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
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use Recaptcha\Controller\Component\RecaptchaComponent;
use Recaptcha\Recaptcha\Recaptcha;

/**
 * Recaptcha\Controller\Component\RecaptchaComponent Test Case
 */
class RecaptchaComponentTest extends TestCase
{
    /**
     * @var Component Component
     */
    public $component = null;

    /**
     * @var Controller Controller
     */
    public $controller = null;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        // $request = new Request();
        // $response = new Response();
        // $this->controller = $this->getMock(
        //     'Cake\Controller\Controller',
        //     [],
        //     [$request, $response]
        // );

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
     * Test StartupWithExistingConfigFile
     *
     * @return void
     */
    public function testStartupWithExistingConfigFile()
    {
        $this->markTestIncomplete("Not yet");
    }
    //
    // /**
    //  * testVerify
    //  *
    //  * @return void
    //  */
    // public function testVerify()
    // {
    //     $response = new RecaptchaResponse();
    //     // instantiate Recaptcha object that deals with retrieving data from google recaptcha
    //     $recaptcha = new Recaptcha($response, 'good-secret');
    //
    //     $this->controller->request->data([
    //         "g-recaptcha-response" => "good-response"
    //     ]);
    //     $this->assertFalse($this->controller->verify());
    //     $this->assertFalse($this->controller->verify());
    //     $this->assertEmpty($this->controller->verify());
    // }
}
