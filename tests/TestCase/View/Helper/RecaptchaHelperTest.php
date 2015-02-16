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
}
