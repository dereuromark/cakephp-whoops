<?php

namespace CakephpWhoops\Test\TestCase\Error\Middleware;

use Cake\TestSuite\TestCase;
use CakephpWhoops\Error\Middleware\WhoopsHandlerMiddleware;

/**
 * Error handling middleware.
 *
 * Custom ErrorHandler to not mix the 404 exceptions with the rest of "real" errors in the error.log file.
 *
 * Also uses Whoops
 */
class WhoopsHandlerMiddlewareTest extends TestCase {

	/**
	 * Execute at least for syntax check
	 *
	 * @return void
	 */
	public function testMiddleware() {
		new WhoopsHandlerMiddleware();

		$this->assertTrue(true);
	}

}
