<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    public static function render(string $template, array $data = [], string $layout = 'app'): string
    {
        $viewsPath = (string) Config::get('app.paths.views');
        $templatePath = $viewsPath . '/' . $template . '.php';
        $layoutPath = $viewsPath . '/layouts/' . $layout . '.php';

        if (! is_file($templatePath)) {
            throw new RuntimeException('Vue introuvable : ' . $template);
        }

        extract($data, EXTR_SKIP);
        $content = self::capture($templatePath, $data);

        return self::capture($layoutPath, array_merge($data, [
            'content' => $content,
            'template' => $template,
        ]));
    }

    public static function partial(string $partial, array $data = []): void
    {
        $viewsPath = (string) Config::get('app.paths.views');
        $partialPath = $viewsPath . '/partials/' . $partial . '.php';

        if (! is_file($partialPath)) {
            throw new RuntimeException('Partial introuvable : ' . $partial);
        }

        extract($data, EXTR_SKIP);
        require $partialPath;
    }

    private static function capture(string $path, array $data = []): string
    {
        ob_start();
        extract($data, EXTR_SKIP);
        require $path;

        return (string) ob_get_clean();
    }
}
