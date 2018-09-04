<?php

namespace CakephpWhoops\Error;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception as CakeException;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class WhoopsHandler extends ErrorHandler {

	use WhoopsTrait;

	/**
	 * @param array $error
	 * @param bool $debug
	 * @return void
	 */
	protected function _displayError($error, $debug) {
		if (!$debug) {
			parent::_displayError($error, $debug);
			return;
		}

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($this->getHandler());
		$whoops->handleError($error['level'], $error['description'], $error['file'], $error['line']);
	}

	/**
	 * @param \Exception $exception
	 * @return void
	 */
	protected function _displayException($exception) {
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
		$request = Router::getRequest(true);
		if ($request instanceof ServerRequest) {
			$handler->addDataTable('Cake Request', $request->params);
		}

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($handler);
		$whoops->handleException($exception);
	}

}
