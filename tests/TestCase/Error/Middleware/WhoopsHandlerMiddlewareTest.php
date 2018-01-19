<?php

namespace CakephpWhoops\Test\TestCase\Error\Middleware;

use CakephpWhoops\Error\Middleware\WhoopsHandlerMiddleware;
use Cake\TestSuite\TestCase;

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
	}

}
