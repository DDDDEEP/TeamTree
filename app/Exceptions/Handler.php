<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**TTP response.
     *
     * Render an exception into an H
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $reposne_json_classes = [
            'Illuminate\Auth\Access\AuthorizationException',
            'Illuminate\Database\Eloquent\ModelNotFoundException',
        ];
        if (in_array(get_class($exception), $reposne_json_classes)) {
            return ResponseJson([], $exception->getMessage());
        }
        // dd(get_class($exception));
        return parent::render($request, $exception);
    }
}
