<?php
/**
 * RecaptchaHelperTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
 */
namespace Recaptcha\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Recaptcha\View\Helper\RecaptchaHelper;

/**
 * Recaptcha\View\Helper\RecaptchaHelper Test Case
 */
class RecaptchaHelperTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Recaptcha = new RecaptchaHelper($view);
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

    public function testDisplay()
    {
        $lang = 'en';
        $siteKey = 'goodKey';
        $theme = 'light';
        $type = 'image';

        $expected = '<div class="g-recaptcha" data-sitekey="goodKey" data-theme="light" data-type="image"></div>
        <script type="text/javascript"
        src="https://www.google.com/recaptcha/api.js?hl=en">
        </script>';

        $actual = $this->Recaptcha->display($siteKey, $lang, $theme, $type);

        $this->assertEquals($expected, $actual);
    }

    public function testDisplayWithEmptyValues()
    {
        $lang = '';
        $siteKey = '';
        $theme = '';
        $type = '';

        $expected = '<div class="g-recaptcha" data-sitekey="" data-theme="light" data-type="image"></div>
        <script type="text/javascript"
        src="https://www.google.com/recaptcha/api.js?hl=en">
        </script>';

        $actual = $this->Recaptcha->display($siteKey, $lang, $theme, $type);

        $this->assertEquals($expected, $actual);
    }

    public function testMultipleWidgets()
    {
        $id = 1;
        $siteKey = '';
        $options = [
            'theme' => '',
            'type' => '',
            'lang' => '',
            'callback' => '',
            'action' => ''
        ];

        $expected = '
        <form action="javascript:alert(grecaptcha.getResponse(widgetId1));">
          <div id="example1"></div>
          <br>
          <input type="submit" value="getResponse">
        </form>
        <br>
        <form action="javascript:grecaptcha.reset(widgetId2);">
          <div id="example2"></div>
          <br>
          <input type="submit" value="reset">
        </form>
        <br>
        <form action="?" method="POST">
          <div id="example3"></div>
          <br>
          <input type="submit" value="Submit">
        </form>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>';

        $actual = $this->Recaptcha->display($id, $siteKey, $options);

        //$this->assertEquals($expected, $actual);
    }

    public function testMultipleWidgetsHeadScript()
    {
        // add widget
        $id = 1;
        $siteKey = '';
        $options = [
            'theme' => '',
            'type' => '',
            'lang' => '',
            'callback' => '',
            'action' => ''
        ];
        $this->Recaptcha->display($id, $siteKey, $options);

        $expected = '';

        $actual = $this->Recaptcha->script();

        //$this->assertEquals($expected, $actual);
    }
}
