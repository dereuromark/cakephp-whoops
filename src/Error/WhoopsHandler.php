<?php

namespace CakephpWhoops\Error;

use Cake\Core\Configure;
use Cake\Error\ErrorHandler;

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

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($this->getHandler());
		$whoops->handleException($exception);
	}

}
