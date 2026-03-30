<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exceptions\HttpException;
use Throwable;

final class App
{
    private Router $router;

    public function __construct(
        private readonly string $basePath,
    ) {
        Config::set('app', require $this->basePath . '/config/app.php');
        Config::set('database', require $this->basePath . '/config/database.php');

        Session::configure((array) Config::get('app.session', []));

        $this->router = new Router();
        $routes = require $this->basePath . '/config/routes.php';
        $routes($this->router);
    }

    public function run(): void
    {
        Session::start();
        Csrf::token();

        $request = Request::capture();

        try {
            $response = $this->router->dispatch($request);
        } catch (HttpException $exception) {
            $response = $this->renderHttpException($exception);
        } catch (Throwable $exception) {
            $this->logException($exception);
            $response = $this->renderThrowable($exception);
        }

        $response->send();
    }

    private function renderHttpException(HttpException $exception): Response
    {
        $status = $exception->statusCode();
        $template = in_array($status, [403, 404], true) ? 'errors/' . $status : 'errors/500';

        return Response::html(
            View::render($template, [
                'message' => $exception->getMessage(),
                'statusCode' => $status,
            ]),
            $status,
        );
    }

    private function renderThrowable(Throwable $exception): Response
    {
        return Response::html(
            View::render('errors/500', [
                'message' => Config::get('app.debug')
                    ? $exception->getMessage()
                    : 'Une erreur technique est survenue. Merci de reessayer plus tard.',
                'statusCode' => 500,
                'debugTrace' => Config::get('app.debug') ? $exception->getTraceAsString() : null,
            ]),
            500,
        );
    }

    private function logException(Throwable $exception): void
    {
        $logPath = (string) Config::get('app.paths.logs', $this->basePath . '/storage/logs');

        if (! is_dir($logPath)) {
            mkdir($logPath, 0775, true);
        }

        $entry = sprintf(
            "[%s] %s in %s:%d\n%s\n\n",
            date('c'),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString(),
        );

        file_put_contents($logPath . '/app.log', $entry, FILE_APPEND);
    }
}
