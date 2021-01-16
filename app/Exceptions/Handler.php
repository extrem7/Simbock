<?php

namespace App\Exceptions;

use Auth;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Route2Class;
use SEO;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($this->isHttpException($exception) || $exception instanceof ModelNotFoundException) {
            if ($exception instanceof ModelNotFoundException || $exception->getStatusCode() == 404) {
                SEO::setTitle('404');
                Route2Class::addClass('bg-linear-gradient-violet');
                Route2Class::addClass('page-error');

                if (Auth::check()) {
                    $domain = Str::of($request->getHost());
                    if (Auth::getUser()->hasRole('admin') && $domain->contains('admin')) {
                        return response()->view('admin::errors.404', [], 404);
                    }
                }

                return response()->view('frontend::errors.404', [
                    'code' => '404',
                    'title' => 'Oops! Page not found',
                    'message' => 'We couldn\'t find the page you were looking for. Maybe our FAQ or Community can help?',
                    'image' => 404
                ], 404);
            }

            if ($exception->getStatusCode() === 403) {
                SEO::setTitle('Forbidden');
                Route2Class::addClass('bg-linear-gradient-violet');
                Route2Class::addClass('page-error');

                return response()->view('frontend::errors.404', [
                    'code' => '403',
                    'title' => 'Your haven\'t permission to do it.',
                    'message' => $exception->getMessage(),
                    'image' => 403

                ], 403);
            }
        }

        if ($request->ajax()) {
            if ($exception instanceof ValidationException)
                return response()->json([
                    'message' => 'You have validation errors.',
                    'errors' => $exception->validator->messages()->toArray()
                ], 422);
        }

        return parent::render($request, $exception);
    }
}
