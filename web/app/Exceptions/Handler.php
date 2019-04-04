<?php

namespace App\Exceptions;

use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * @var ResponseApiInterface $responseApi
     */
    private $responseApi;

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function __construct(Container $container, ResponseApiInterface $responseApi)
    {
        parent::__construct($container);

        $this->responseApi = $responseApi;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ApiException) {
            return $this->responseApi->error(Arr::wrap($exception->getMessage()));
        }

        if ($exception instanceof UnauthorizedHttpException && $request->expectsJson()) {
            return $this->responseApi->error(Arr::wrap($exception->getMessage()));
        }

        return parent::render($request, $exception);
    }
}
