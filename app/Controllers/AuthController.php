<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\UserRepository;

final class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $users = new UserRepository(),
    ) {
    }

    public function showLogin(Request $request): Response
    {
        if (Auth::check()) {
            return $this->redirect($this->defaultRedirect((string) Auth::role()));
        }

        return $this->view('auth/login', [
            'email' => '',
            'errors' => [],
        ]);
    }

    public function login(Request $request): Response
    {
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');
        $errors = [];

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Merci de saisir une adresse email valide.';
        }

        if ($password === '') {
            $errors['password'] = 'Merci de saisir votre mot de passe.';
        }

        if ($errors !== []) {
            return $this->view('auth/login', [
                'email' => $email,
                'errors' => $errors,
            ], 422);
        }

        $user = $this->users->findByEmail($email);

        if (! is_array($user) || ! password_verify($password, (string) $user['password_hash'])) {
            return $this->view('auth/login', [
                'email' => $email,
                'errors' => ['credentials' => 'Identifiants invalides.'],
            ], 422);
        }

        unset($user['password_hash']);
        Auth::login($user);
        Session::flash('success', 'Connexion reussie.');

        $intended = Session::pull('auth.intended');

        if (is_string($intended) && $intended !== '' && $intended !== '/login') {
            return $this->redirect($intended);
        }

        return $this->redirect($this->defaultRedirect((string) $user['role']));
    }

    public function logout(Request $request): Response
    {
        Auth::logout();
        Session::flash('success', 'Vous avez ete deconnecte.');

        return $this->redirect('/');
    }

    private function defaultRedirect(string $role): string
    {
        return match ($role) {
            'etudiant' => '/dashboard/etudiant',
            'pilote' => '/dashboard/pilote',
            'administrateur' => '/dashboard/admin',
            default => '/',
        };
    }
}
