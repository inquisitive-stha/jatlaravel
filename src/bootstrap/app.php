<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //        config('app.env') === 'local' ? $e->getFile() . ': Line:' . $e->getLine() : null

        $exceptions->render(function (Exception $e, Request $request) {
            $className = get_class($e);

            if ($className === ValidationException::class) {
                $errors = [];
                foreach ($e->errors() as $key => $value) {
                    foreach ($value as $message) {
                        $errors[] = [
                            'status'  => 422,
                            'message' => $message,
                            'source'  => $key
                        ];
                    }
                }

                return response()->json([
                    'errors' => $errors
                ]);
            }

            if ($className === NotFoundHttpException::class) {
                $previousException = $e->getPrevious();

                if ($previousException instanceof ModelNotFoundException) {
                    return response()->json([
                        'errors' => [
                            'status'  => 404,
                            'message' => config('app.env') != 'production' ? $e->getMessage() : 'The resource cannot be found.',
                            'source'  => $previousException->getModel()
                        ]
                    ]);
                } else {
                    return response()->json([
                        'errors' => [
                            'status'  => 404,
                            'message' => config('app.env') != 'production' ? $e->getMessage(
                            ) : 'This route does not exist.',
                            'source'  => ''
                        ]
                    ]);
                }
            }

            if ($className === MethodNotAllowedHttpException::class) {
                return response()->json([
                    'errors' => [
                        'status'  => 405,
                        'message' => config('app.env') != 'production' ? $e->getMessage() : 'Method not allowed.',
                        'source'  => ''
                    ]
                ]);
            }
        });

    })->create();

