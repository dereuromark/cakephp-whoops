<?php

namespace Gourmet\Whoops\Error\Middleware;

use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Log\Log;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Error handling middleware.
 *
 * Custom ErrorHandler to not mix the 404 exceptions with the rest of "real" errors in the error.log file.
 *
 * Also uses Whoops
 */
class WhoopsHandlerMiddleware extends ErrorHandlerMiddleware {

	/**
	 * @var \Whoops\Run
	 */
	protected $_whoops;

	/**
	 * Log an error for the exception if applicable.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request The current request.
	 * @param \Exception $exception The exception to log a message for.
	 * @return void
	 */
	protected function logException($request, $exception) {
		if ($this->is404($exception, $request)) {
			$level = LOG_ERR;
			Log::write($level, $this->getMessage($request, $exception), ['404']);
			return;
		}

		parent::logException($request, $exception);
	}

	/**
	 * @param \Exception $exception The exception to handle.
	 * @param \Psr\Http\Message\ServerRequestInterface $request The request.
	 * @param \Psr\Http\Message\ResponseInterface $response The response.
	 * @return \Psr\Http\Message\ResponseInterface A response
	 */
	public function handleException($exception, $request, $response) {
		if (!Configure::read('debug')) {
			parent::handleException($exception, $request, $response);
		}

		$whoops = $this->getWhoopsInstance();
		$whoops->pushHandler($this->getHandler());
		$whoops->handleException($exception);

		//Won't be reached anymore
		return $response;
	}

	/**
	 * @return \Whoops\Run
	 */
	protected function getWhoopsInstance() {
		if (empty($this->_whoops)) {
			$this->_whoops = new Run();
		}
		return $this->_whoops;
	}

	/**
	 * @return \Whoops\Handler\PrettyPageHandler
	 */
	protected function getHandler() {
		$handler = new PrettyPageHandler();
		if (!Configure::read('Whoops.editor')) {
			return $handler;
		}

		$handler->setEditor(function ($file, $line) {
			$userPath = Configure::read('Whoops.userBasePath');
			$serverPath = Configure::read('Whoops.serverBasePath');
			if ($userPath && $serverPath) {
				$file = str_replace($serverPath, $userPath, $file);
			}
			$pattern = Configure::read('Whoops.ideLinkPattern') ?: 'phpstorm://open?file=%s&line=%s';
			$url = sprintf($pattern, $file, $line);
			if (!Configure::read('Whoops.asAjax', false)) {
				return $url;
			}
			return [
				'url' => $url,
				'ajax' => true,
			];
		});

		return $handler;
	}

}
