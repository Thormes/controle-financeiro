<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DomainException;
use App\Exceptions\Responser;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof DomainException) {
            return Responser::error(400, $exception->getMessage());
        }
        if ($exception instanceof ValidationException) {
            return Responser::error(422, $exception->getMessage());
        }
        if ($exception instanceof ModelNotFoundException) {
            return Responser::error(404, sprintf("Entidade do tipo \"%s\" com id %s não encontrada", str_replace("App\\Models\\", "", (string) $exception->getModel()), implode(", ", $exception->getIds())));
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return Responser::error(404, sprintf("Caminho \"%s\" não é válido", $request->url()));
        }
        if ($exception instanceof
            \Illuminate\Auth\AuthenticationException
        ) {
            return Responser::error(403, "Usuário não tem permissão para acessar esse recurso");
        }
        if (str_contains($exception->getMessage(), "[login]") && $exception instanceof RouteNotFoundException) {
            return Responser::error(401, "Usuário não está autenticado (token ausente ou inválido)");
        }
        return Responser::error(500, $exception->getMessage());
    }
}
