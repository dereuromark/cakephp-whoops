<?php

namespace CakephpWhoops\Error;

use Cake\Core\Configure;
use Cake\Core\Exception\CakeException;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Throwable;

class WhoopsHandler extends ErrorHandler {

	use WhoopsTrait;

	/**
	 * @param array $error An array of error data.
	 * @param bool $debug Whether or not the app is in debug mode.
	 * @return void
	 */
	protected function _displayError(array $error, bool $debug): void {
		if (!$debug) {
			parent::_displayError($error, $debug);

			return;
		}

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($this->getHandler());
		$whoops->handleError($error['level'], $error['description'], $error['file'], $error['line']);
	}

	/**
	 * @param \Throwable $exception The exception to display.
	 * @throws \Exception When the chosen exception renderer is invalid.
	 * @return void
	 */
	protected function _displayException(Throwable $exception): void {
		if (!Configure::read('debug')) {
			parent::_displayException($exception);

			return;
		}

		$handler = $this->getHandler();

		// Include all attributes defined in Cake Exception as a data table
		if ($exception instanceof CakeException) {
			$handler->addDataTable('Cake Exception', $exception->getAttributes());
		}

		// Include all request parameters as a data table
		$request = Router::getRequest();
		if ($request instanceof ServerRequest) {
			$handler->addDataTable('Cake Request', $request->getAttribute('params'));
		}

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($handler);
		$whoops->handleException($exception);
	}

}
