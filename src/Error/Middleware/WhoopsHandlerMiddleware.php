<?php

namespace CakephpWhoops\Error\Middleware;

use CakephpWhoops\Error\WhoopsTrait;
use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * Error handling middleware.
 *
 * Custom ErrorHandler to not mix the 404 exceptions with the rest of "real" errors in the error.log file.
 *
 * Also uses Whoops
 */
class WhoopsHandlerMiddleware extends ErrorHandlerMiddleware {

	use WhoopsTrait;

	const PHP_SAPI_CLI = 'cli';

	/**
	 * @param \Throwable $exception The exception to handle.
	 * @param \Psr\Http\Message\ServerRequestInterface $request The request.
	 * @return \Psr\Http\Message\ResponseInterface A response
	 */
	public function handleException(Throwable $exception, ServerRequestInterface $request): ResponseInterface {
		if (!Configure::read('debug') || PHP_SAPI === static::PHP_SAPI_CLI || $request->is('json')) {
			return parent::handleException($exception, $request);
		}

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($this->getHandler());
		$whoops->handleException($exception);

		//Won't be reached anymore
		return parent::handleException($exception, $request);
	}

}
