<?php
declare(strict_types=1);

namespace CakephpWhoops\Error;

use Cake\Core\Exception\CakeException;
use Cake\Error\ExceptionRendererInterface;
use Cake\Http\ResponseEmitter;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class WhoopsExceptionRenderer implements ExceptionRendererInterface {

	use WhoopsTrait;

	protected Throwable $exception;

	protected ?ServerRequest $request;

	/**
	 * @param \Throwable $exception
	 * @param \Cake\Http\ServerRequest|null $request
	 */
	public function __construct(Throwable $exception, ?ServerRequest $request = null) {
		$this->exception = $exception;
		$this->request = $request;
	}

	/**
	 * @inheritDoc
	 */
	public function render(): string {
		$whoops = $this->getWhoopsInstance();
		$handler = $this->getHandler();

		// Include all attributes defined in Cake Exception as a data table
		if ($this->exception instanceof CakeException) {
			$handler->addDataTable('Cake Exception', $this->exception->getAttributes());
		}

		// Include all request parameters as a data table
		$request = Router::getRequest();
		if ($request instanceof ServerRequest) {
			$handler->addDataTable('Cake Request', $request->getAttribute('params'));
		}

		$whoops->pushHandler($handler);
		$whoops->handleException($this->exception);

		return '';
	}

	/**
	 * @inheritDoc
	 */
	public function write(ResponseInterface|string $output): void {
		if (is_string($output)) {
			echo $output;

			return;
		}

		$emitter = new ResponseEmitter();
		$emitter->emit($output);
	}

}
