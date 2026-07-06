<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {

            if ($e instanceof HttpExceptionInterface && $e->getStatusCode() === 413) {

                $message = 'Ukuran file atau data yang dikirim terlalu besar. Maksimal 2MB per file.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $message,
                    ], 413);
                }

                return back()
                    ->withErrors([
                        'file_path' => $message,
                    ])
                    ->withInput();
            }
        });
    }
}