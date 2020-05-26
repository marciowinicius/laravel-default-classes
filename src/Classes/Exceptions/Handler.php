<?php

namespace MarcioWinicius\LaravelDefaultClasses\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function prepareJsonResponse($request, Exception $exception)
    {
        // $request = Request::capture();
        // Log::warning(
        //     'Rota:' . $request->method() . ' ' . $request->getRequestUri() . '  ' .
        //     'IP:' . $request->ip() . '  ' .
        //     'message:' . $exception->getMessage()
        // );

        if (get_class($exception) == 'MarcioWinicius\LaravelDefaultClasses\Exceptions\UserNotAuthenticatedException') {
            return response()->json([
                'error' => 1,
                'exception' => get_class($exception),
                'message' => 'Authentication error',
                'data' => $exception->getMessageBag(),
            ], 401);
        }

        if ($exception instanceof ValidatorException) {
            return response()->json([
                'error' => 1,
                'exception' => get_class($exception),
                'message' => 'Validation error',
                'data' => $exception->getMessageBag(),
            ], 400);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 1,
                'exception' => get_class($exception),
                'message' => 'The resource you are trying to access was not found.',
                'data' => $this->getTrace($exception)
            ], 404);

        }

        $exception = FlattenException::create($exception);

        if (config('app.debug')) {
            $message = $exception->getMessage();
        } else {
            $message = Response::$statusTexts[$exception->getStatusCode()];
        }

        return response()->json([
            'error' => 1,
            'exception' => $exception->getStatusCode() . ' - ' . $exception->getClass(),
            'message' => 'Error - ' . $exception->getStatusCode() . ' - ' . $message,
            'data' => $exception->getTrace($exception),
        ], 400);
    }

    private function getTrace($exception)
    {
        if (config('app.debug')) {
            return 'file: ' . $exception->getFile() . ' line: ' . $exception->getLine();
        }

        return null;
    }
}
