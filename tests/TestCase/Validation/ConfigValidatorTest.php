<?php
/**
 * ConfigValidatorTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Test\TestCase\Recaptcha;

use Cake\TestSuite\TestCase;
use Recaptcha\Validation\ConfigValidator;

/**
 * Recaptcha\Lib\RecaptchaResponse Test Case
 */
class ConfigValidatorTest extends TestCase
{

    /**
     * Test Config Validation with missing secret param
     *
     * @return void
     */
    public function testConfigValidationWithMissingSecretParam()
    {
        $validator = new ConfigValidator();
        $data = ['lang' => 'fr'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('secret', $errors);

        $validator = new ConfigValidator();
        $data = ['theme' => 'light'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('secret', $errors);

        $validator = new ConfigValidator();
        $data = ['type' => 'image'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('secret', $errors);

        $validator = new ConfigValidator();
        $data = ['size' => 'normal'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('secret', $errors);
    }

    /**
     * Test Config Validation with existing params
     *
     * @return void
     */
    public function testConfigValidationWithExistingParams()
    {
        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'lang' => 'fr'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'theme' => 'light'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'type' => 'image'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'size' => 'normal'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);
    }

    /**
     * Test Global Validation with non existing params
     *
     * @return void
     */
    public function testConfigValidationWithNonExistingParams()
    {
        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'lang' => 'non-existing-lang'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('lang', $errors);

        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'theme' => 'non-existing-theme'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('theme', $errors);

        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'type' => 'non-existing-type'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('type', $errors);

        $validator = new ConfigValidator();
        $data = ['secret' => 'fff', 'size' => 'non-existing-size'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('size', $errors);
    }

    /**
     * Test Global Validation with block of existing params
     *
     * @return void
     */
    public function testConfigValidationWithBlockOfExistingParams()
    {
        $validator = new ConfigValidator();
        $data = [
            'secret' => 'fff',
            'lang' => 'fr',
            'theme' => 'dark',
            'type' => 'audio',
            'size' => 'compact'
        ];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);
    }

    /**
     * Test Global Validation with block of non existing params
     *
     * @return void
     */
    public function testConfigValidationWithBlockOfNonExistingParams()
    {
        $validator = new ConfigValidator();
        $data = [
            'secret' => 'fff',
            'lang' => 'non-existing-lang',
            'theme' => 'non-existing-theme',
            'type' => 'non-existing-type',
            'size' => 'non-existing-size'
        ];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('lang', $errors);
        $this->assertArrayHasKey('theme', $errors);
        $this->assertArrayHasKey('type', $errors);
        $this->assertArrayHasKey('size', $errors);
    }
}
