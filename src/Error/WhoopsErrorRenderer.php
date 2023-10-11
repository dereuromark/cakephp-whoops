<?php
declare(strict_types=1);

namespace CakephpWhoops\Error;

use Cake\Error\ErrorRendererInterface;
use Cake\Error\PhpError;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class WhoopsErrorRenderer implements ErrorRendererInterface {

	use WhoopsTrait;

	/**
	 * @inheritDoc
	 */
	public function render(PhpError $error, bool $debug): string {
		$whoops = $this->getWhoopsInstance();
		$handler = $this->getHandler();

		// Include all request parameters as a data table
		$request = Router::getRequest();
		if ($request instanceof ServerRequest) {
			$handler->addDataTable('Cake Request', $request->getAttribute('params'));
		}

		$whoops->pushHandler($this->getHandler());
		$whoops->handleError($error->getLogLevel(), $error->getMessage(), $error->getFile(), $error->getLine());

		return '';
	}

	/**
	 * @inheritDoc
	 */
	public function write(string $out): void {
		echo $out;
	}

}
