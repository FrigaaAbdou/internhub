<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exceptions\HttpException;

abstract class Controller
{
    protected function view(string $template, array $data = [], int $status = 200, string $layout = 'app'): Response
    {
        $data['metaTitle'] = page_meta_title($template, $data);
        $data['metaDescription'] = page_meta_description($template, $data);

        return Response::html(View::render($template, $data, $layout), $status);
    }

    protected function json(array $data, int $status = 200): Response
    {
        return Response::json($data, $status);
    }

    protected function redirect(string $path, int $status = 302): Response
    {
        return Response::redirect($path, $status);
    }

    protected function abort(int $status, string $message = ''): never
    {
        throw match ($status) {
            403 => HttpException::forbidden($message),
            404 => HttpException::notFound($message),
            default => HttpException::serverError($message),
        };
    }
}
