<?php
/**
 * RecaptchaResponseTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Test\TestCase\Recaptcha;

use Cake\TestSuite\TestCase;
use Recaptcha\Recaptcha\RecaptchaResponse;

/**
 * Recaptcha\Lib\RecaptchaResponse Test Case
 */
class RecaptchaResponseTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->RecaptchaResponse = new RecaptchaResponse();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RecaptchaResponse);

        parent::tearDown();
    }

    /**
     * Test Success To True
     *
     * @return void
     */
    public function testSuccessTrue()
    {
        $this->RecaptchaResponse->setSuccess(true);
        $this->assertEquals(true, $this->RecaptchaResponse->isSuccess());
    }

    /**
     * Test Success To False
     *
     * @return void
     */
    public function testSuccessFalse()
    {
        $this->RecaptchaResponse->setSuccess(false);
        $this->assertEquals(false, $this->RecaptchaResponse->isSuccess());
    }

    /**
     * Test Success With Wrong Inputs
     *
     * @return void
     */
    public function testSuccessWithWrongInputs()
    {
        $this->RecaptchaResponse->setSuccess('ee');
        $this->assertEquals(null, $this->RecaptchaResponse->isSuccess());

        $this->RecaptchaResponse->setSuccess(['eee', 'e']);
        $this->assertEquals(null, $this->RecaptchaResponse->isSuccess());
    }

    /**
     * Test Error Codes
     *
     * @return void
     */
    public function testErrorCodesThatWorks()
    {
        $this->RecaptchaResponse->setErrorCodes(['invalid-input-response']);
        $this->assertEquals(['invalid-input-response'], $this->RecaptchaResponse->errorCodes());
    }

    /**
     * Test Error Codes With Wrong Inputs
     *
     * @return void
     */
    public function testErrorCodesWithWrongInputs()
    {
        $this->RecaptchaResponse->setErrorCodes(['eee', 'e']);
        $this->assertEquals([], $this->RecaptchaResponse->errorCodes());
    }

    /**
     * Test Set Response
     *
     * @return void
     */
    public function testSetJsonWithWrongInputs()
    {
        $this->RecaptchaResponse->setJson(['eee', 'e']);
        $this->assertEquals(null, $this->RecaptchaResponse->errorCodes());
        $this->assertEquals(null, $this->RecaptchaResponse->isSuccess());
    }

    /**
     * Test Set Response
     *
     * @return void
     */
    public function testSetResponseWithGoodInputs()
    {
        $this->RecaptchaResponse->setJson(['error-codes' => ['input-error'], 'success' => true]);
        $this->assertEquals([], $this->RecaptchaResponse->errorCodes());
        $this->assertEquals(true, $this->RecaptchaResponse->isSuccess());

        $this->RecaptchaResponse->setJson(['error-codes' => ['missing-input-secret'], 'success' => true]);
        $this->assertEquals(['missing-input-secret'], $this->RecaptchaResponse->errorCodes());
        $this->assertEquals(true, $this->RecaptchaResponse->isSuccess());

        $this->RecaptchaResponse->setJson(['error-codes' => ['missing-input-secret', 'invalid-input-secret', 'eee'], 'success' => true]);
        $this->assertEquals(['missing-input-secret', 'invalid-input-secret'], $this->RecaptchaResponse->errorCodes());
        $this->assertEquals(true, $this->RecaptchaResponse->isSuccess());
    }
}
