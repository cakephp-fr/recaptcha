<?php
/**
 * GlobalValidatorTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Test\TestCase\Recaptcha;

use Cake\TestSuite\TestCase;
use Recaptcha\Validation\GlobalValidator;

/**
 * Recaptcha\Lib\RecaptchaResponse Test Case
 */
class GlobalValidatorTest extends TestCase
{

    /**
     * Test Global Validation with existing params
     *
     * @return void
     */
    public function testGlobalValidationWithExistingParams()
    {
        $validator = new GlobalValidator();
        $data = ['lang' => 'fr'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new GlobalValidator();
        $data = ['theme' => 'light'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new GlobalValidator();
        $data = ['type' => 'image'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);

        $validator = new GlobalValidator();
        $data = ['size' => 'normal'];
        $errors = $validator->errors($data);
        $this->assertEmpty($errors);
    }

    /**
     * Test Global Validation with non existing params
     *
     * @return void
     */
    public function testGlobalValidationWithNonExistingParams()
    {
        $validator = new GlobalValidator();
        $data = ['lang' => 'non-existing-lang'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('lang', $errors);

        $validator = new GlobalValidator();
        $data = ['theme' => 'non-existing-theme'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('theme', $errors);

        $validator = new GlobalValidator();
        $data = ['type' => 'non-existing-type'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('type', $errors);

        $validator = new GlobalValidator();
        $data = ['size' => 'non-existing-size'];
        $errors = $validator->errors($data);
        $this->assertArrayHasKey('size', $errors);
    }

    /**
     * Test Global Validation with block of existing params
     *
     * @return void
     */
    public function testGlobalValidationWithBlockOfExistingParams()
    {
        $validator = new GlobalValidator();
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
     * Test Global Validation with block of non existing params
     *
     * @return void
     */
    public function testGlobalValidationWithBlockOfNonExistingParams()
    {
        $validator = new GlobalValidator();
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
