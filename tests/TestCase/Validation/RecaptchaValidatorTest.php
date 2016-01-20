<?php
/**
 * RecaptchaValidatorTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Test\TestCase\Recaptcha;

use Cake\TestSuite\TestCase;
use Recaptcha\Validation\RecaptchaValidator;

/**
 * Recaptcha\Lib\RecaptchaResponse Test Case
 */
class RecaptchaValidatorTest extends TestCase
{

    /**
     * Test Recaptcha Validation with existing params
     *
     * @return void
     */
    public function testRecaptchaValidationWithExistingParams()
    {
        $validator = new RecaptchaValidator();
        $data = ['lang' => 'fr'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new RecaptchaValidator();
        $data = ['theme' => 'light'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new RecaptchaValidator();
        $data = ['type' => 'image'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new RecaptchaValidator();
        $data = ['size' => 'normal'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);
    }

    /**
     * Test Recaptcha Validation with non existing params
     *
     * @return void
     */
    public function testRecaptchaValidationWithNonExistingParams()
    {
        $validator = new RecaptchaValidator();
        $data = ['lang' => 'non-existing-lang'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('lang', $errors);

        $validator = new RecaptchaValidator();
        $data = ['theme' => 'non-existing-theme'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('theme', $errors);

        $validator = new RecaptchaValidator();
        $data = ['type' => 'non-existing-type'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('type', $errors);

        $validator = new RecaptchaValidator();
        $data = ['size' => 'non-existing-size'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('size', $errors);
    }

    /**
     * Test Recaptcha Validation with block of existing params
     *
     * @return void
     */
    public function testRecaptchaValidationWithBlockOfExistingParams()
    {
        $validator = new RecaptchaValidator();
        $data = [
            'lang' => 'fr',
            'theme' => 'dark',
            'type' => 'audio',
            'size' => 'compact'
        ];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);
    }

    /**
     * Test Recaptcha Validation with block of non existing params
     *
     * @return void
     */
    public function testRecaptchaValidationWithBlockOfNonExistingParams()
    {
        $validator = new RecaptchaValidator();
        $data = [
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
