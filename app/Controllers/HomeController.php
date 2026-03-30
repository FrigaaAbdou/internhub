<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Config;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;

final class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->view('home/index', [
            'appName' => Config::get('app.name', 'InternHub'),
            'environment' => Config::get('app.env', 'local'),
            'debug' => (bool) Config::get('app.debug', false),
            'requestPath' => $request->path(),
            'hasDatabaseDsn' => Config::get('database.dsn') !== '' || Config::get('database.host') !== null,
            'user' => Auth::user(),
        ]);
    }

    public function legalNotices(Request $request): Response
    {
        return $this->view('legal/mentions', [
            'publisher' => Config::get('app.legal.publisher', 'Projet pedagogique InternHub'),
            'director' => Config::get('app.legal.director', 'Equipe projet InternHub'),
            'contactEmail' => Config::get('app.legal.contact_email', 'contact@internhub.test'),
            'hosting' => Config::get('app.legal.hosting', 'Hebergement local ou environnement de demonstration'),
            'appName' => Config::get('app.name', 'InternHub'),
        ]);
    }

    public function health(Request $request): Response
    {
        return $this->json([
            'status' => 'ok',
            'app' => Config::get('app.name', 'InternHub'),
            'environment' => Config::get('app.env', 'local'),
            'path' => $request->path(),
            'timestamp' => date(DATE_ATOM),
        ]);
    }
}
