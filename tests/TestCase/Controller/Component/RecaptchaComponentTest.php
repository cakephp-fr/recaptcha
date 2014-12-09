<?php
namespace Recaptcha\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Recaptcha\Controller\Component\RecaptchaComponent;

/**
 * Recaptcha\Controller\Component\RecaptchaComponent Test Case
 */
class RecaptchaComponentTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$registry = new ComponentRegistry();
		$this->Recaptcha = new RecaptchaComponent($registry);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Recaptcha);

		parent::tearDown();
	}

/**
 * Test initial setup
 *
 * @return void
 */
	public function testInitialization() {
		$this->markTestIncomplete('Not implemented yet.');
	}

/**
 * Test Startup
 *
 * @return void
 */
	public function testStartup() {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
