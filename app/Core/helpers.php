<?php

declare(strict_types=1);

use App\Core\Config;
use App\Core\Csrf;
use App\Core\Auth;
use App\Core\Session;

if (! function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        return $value === false || $value === null || $value === '' ? $default : $value;
    }
}

if (! function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        return Config::get($key, $default);
    }
}

if (! function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (! function_exists('url')) {
    function url(string $path = '/'): string
    {
        $baseUrl = (string) config('app.url', '');
        $normalizedPath = '/' . ltrim($path, '/');

        if ($baseUrl === '') {
            return $normalizedPath;
        }

        return rtrim($baseUrl, '/') . ($normalizedPath === '/' ? '' : $normalizedPath);
    }
}

if (! function_exists('asset')) {
    function asset(string $path): string
    {
        return url($path);
    }
}

if (! function_exists('url_with_query')) {
    function url_with_query(string $path, array $params = []): string
    {
        $query = http_build_query(
            array_filter(
                $params,
                static fn (mixed $value): bool => $value !== null && $value !== ''
            )
        );

        return $query === '' ? url($path) : url($path) . '?' . $query;
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return Csrf::token();
    }
}

if (! function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . e(Csrf::token()) . '">';
    }
}

if (! function_exists('flash')) {
    function flash(string $key, mixed $value): void
    {
        Session::flash($key, $value);
    }
}

if (! function_exists('auth_check')) {
    function auth_check(): bool
    {
        return Auth::check();
    }
}

if (! function_exists('auth_user')) {
    function auth_user(): ?array
    {
        return Auth::user();
    }
}

if (! function_exists('auth_role')) {
    function auth_role(): ?string
    {
        return Auth::role();
    }
}

if (! function_exists('old')) {
    function old(string $key, mixed $default = null): mixed
    {
        return Session::get('_old_input.' . $key, $default);
    }
}

if (! function_exists('page_meta_title')) {
    function page_meta_title(string $template, array $data = []): string
    {
        if (isset($data['metaTitle']) && is_string($data['metaTitle']) && trim($data['metaTitle']) !== '') {
            return trim($data['metaTitle']);
        }

        $appName = (string) config('app.name', 'InternHub');

        if (isset($data['title']) && is_string($data['title']) && trim($data['title']) !== '') {
            return trim($data['title']) . ' | ' . $appName;
        }

        $label = match ($template) {
            'home/index' => 'Accueil',
            'auth/login' => 'Connexion',
            'offers/index' => 'Offres',
            'offers/show' => (string) ($data['offer']['title'] ?? 'Detail de l offre'),
            'offers/manage' => 'Gestion des offres',
            'offers/form' => 'Formulaire offre',
            'companies/index' => 'Entreprises',
            'companies/show' => (string) ($data['company']['name'] ?? 'Fiche entreprise'),
            'companies/manage' => 'Gestion des entreprises',
            'companies/form' => 'Formulaire entreprise',
            'statistics/index' => 'Statistiques',
            'student/dashboard' => 'Dashboard etudiant',
            'student/applications' => 'Mes candidatures',
            'student/create-application' => 'Postuler a une offre',
            'student/show-application' => 'Detail de la candidature',
            'student/profile' => 'Mon profil',
            'student/wishlist' => 'Ma wish-list',
            'pilot/dashboard' => 'Dashboard pilote',
            'pilot/students' => 'Etudiants de la promotion',
            'pilot/student-applications' => 'Candidatures etudiant',
            'pilot/show-student' => 'Fiche etudiant',
            'pilot/show-application' => 'Detail candidature pilote',
            'pilot/create-student' => 'Creer un compte etudiant',
            'pilot/edit-student' => 'Modifier un compte etudiant',
            'admin/dashboard' => 'Dashboard administrateur',
            'admin/accounts' => 'Gestion des comptes',
            'admin/account-form' => 'Formulaire compte',
            'errors/403' => 'Acces refuse',
            'errors/404' => 'Page introuvable',
            'errors/500' => 'Erreur technique',
            'legal/mentions' => 'Mentions legales',
            default => ucwords(str_replace(['-', '_'], ' ', basename($template))),
        };

        return $label . ' | ' . $appName;
    }
}

if (! function_exists('page_meta_description')) {
    function page_meta_description(string $template, array $data = []): string
    {
        if (isset($data['metaDescription']) && is_string($data['metaDescription']) && trim($data['metaDescription']) !== '') {
            return trim($data['metaDescription']);
        }

        $default = (string) config(
            'app.meta.default_description',
            'InternHub centralise les offres de stage, les candidatures, le suivi pedagogique et la gestion des comptes.'
        );

        return match ($template) {
            'home/index' => 'Plateforme de demonstration InternHub pour consulter les offres, suivre les candidatures et gerer les espaces etudiant, pilote et administrateur.',
            'auth/login' => 'Connectez-vous a InternHub pour acceder a votre espace etudiant, pilote ou administrateur.',
            'offers/index' => 'Consultez les offres de stage publiees et filtrez-les par mot-cle, ville ou type de contrat.',
            'offers/show' => trim((string) ($data['offer']['description'] ?? 'Consultez le detail de cette offre de stage sur InternHub.')),
            'offers/manage' => 'Gerez les offres publiees et les brouillons depuis l espace pilote ou administrateur.',
            'companies/index' => 'Parcourez les entreprises referencees dans InternHub et consultez leurs fiches detaillees.',
            'companies/show' => trim((string) ($data['company']['description'] ?? 'Consultez la fiche detaillee de cette entreprise referencee dans InternHub.')),
            'companies/manage' => 'Gerez les entreprises referencees et leur catalogue depuis l espace pilote ou administrateur.',
            'statistics/index' => 'Consultez les indicateurs publics sur les offres, entreprises et candidatures de la plateforme InternHub.',
            'student/dashboard' => 'Retrouvez vos indicateurs, candidatures recentes et raccourcis de suivi dans votre espace etudiant.',
            'student/applications' => 'Consultez l historique de vos candidatures et leur statut actuel.',
            'student/create-application' => 'Deposez une candidature complete avec lettre de motivation et CV.',
            'student/profile' => 'Mettez a jour vos informations personnelles et votre mot de passe.',
            'student/wishlist' => 'Retrouvez les offres sauvegardees dans votre wish-list.',
            'pilot/dashboard' => 'Suivez votre promotion, les candidatures recentes et les acces rapides de supervision.',
            'pilot/students' => 'Consultez les etudiants rattaches a votre promotion et leurs actions de suivi.',
            'admin/dashboard' => 'Supervisez les comptes, entreprises et offres depuis le tableau de bord administrateur.',
            'admin/accounts' => 'Gerez les comptes et les acces pilotes et etudiants.',
            'errors/403' => 'La ressource demandee n est pas accessible avec vos droits actuels.',
            'errors/404' => 'La ressource demandee est introuvable ou n existe plus.',
            'errors/500' => 'Une erreur technique est survenue sur InternHub.',
            'legal/mentions' => 'Consultez les mentions legales et le cadre de demonstration du projet InternHub.',
            default => $default,
        };
    }
}
