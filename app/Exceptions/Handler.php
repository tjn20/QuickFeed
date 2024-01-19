<?php

namespace App\Exceptions;

use Throwable;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            if($exception->getModel()=='App\Models\User')
            return response()->view('errors.404-profile', ['username'=>$request->user], 404);
            if($exception->getModel()=='App\Models\Feed')
            return response()->view('errors.404-feed', [], 404);
            
           
    
    
        }
        return parent::render($request, $exception);
    }
}
