<?php
use App\Http\Middleware\Admin\CheckLogin as CheckLoginAdmin;
use App\Http\Middleware\Client\CheckLogin as CheckLoginClient;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {

            $clientRoutes = [
                'page.php',
                'auth.php',
                'profile.php'

            ];

            $systemRoutes = [
                'admin.php',
                'auth.php',
                'medicalRecord.php',
                'appointmentSchedule.php'
            ];


            foreach ($clientRoutes as $route) {
                Route::middleware('web')
                    ->prefix('')
                    ->name('client.')
                    ->group(base_path("routes/client/{$route}"));
            }

            foreach ($systemRoutes as $route) {
                Route::middleware('web')
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path("routes/system/{$route}"));
            }

            Route::fallback(function () {
                return response()->view('error.404', [], 404);
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_login_admin' => CheckLoginAdmin::class,
            'check_login_client' => CheckLoginClient::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
