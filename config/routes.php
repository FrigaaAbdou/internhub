<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\ApplicationController;
use App\Controllers\AuthController;
use App\Controllers\CompanyController;
use App\Controllers\HomeController;
use App\Controllers\OfferController;
use App\Controllers\PilotController;
use App\Controllers\StatisticsController;
use App\Controllers\StudentController;
use App\Controllers\WishlistController;
use App\Core\Middleware\AuthenticateMiddleware;
use App\Core\Middleware\CsrfMiddleware;
use App\Core\Middleware\EnsureRoleMiddleware;
use App\Core\Router;

return static function (Router $router): void {
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/mentions-legales', [HomeController::class, 'legalNotices']);
    $router->get('/health', [HomeController::class, 'health']);
    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login'], [new CsrfMiddleware()]);
    $router->post('/logout', [AuthController::class, 'logout'], [new AuthenticateMiddleware(), new CsrfMiddleware()]);

    $router->get('/offres', [OfferController::class, 'index']);
    $router->get('/offres/{id}', [OfferController::class, 'show']);
    $router->get('/statistiques', [StatisticsController::class, 'index']);
    $router->post('/offres/{id}/wishlist', [WishlistController::class, 'store'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/pilote/offres', [OfferController::class, 'manage'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/offres/create', [OfferController::class, 'create'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->post('/dashboard/pilote/offres/create', [OfferController::class, 'store'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/pilote/offres/{id}/edit', [OfferController::class, 'edit'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->post('/dashboard/pilote/offres/{id}/edit', [OfferController::class, 'update'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->post('/dashboard/pilote/offres/{id}/delete', [OfferController::class, 'delete'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->get('/offres/{id}/postuler', [ApplicationController::class, 'create'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);
    $router->post('/offres/{id}/postuler', [ApplicationController::class, 'store'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
        new CsrfMiddleware(),
    ]);

    $router->get('/entreprises', [CompanyController::class, 'index']);
    $router->get('/entreprises/{id}', [CompanyController::class, 'show']);
    $router->get('/dashboard/pilote/entreprises', [CompanyController::class, 'manage'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/entreprises/create', [CompanyController::class, 'create'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->post('/dashboard/pilote/entreprises/create', [CompanyController::class, 'store'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/pilote/entreprises/{id}/edit', [CompanyController::class, 'edit'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->post('/dashboard/pilote/entreprises/{id}/edit', [CompanyController::class, 'update'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->post('/dashboard/pilote/entreprises/{id}/delete', [CompanyController::class, 'delete'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);

    $router->get('/dashboard/etudiant/candidatures', [StudentController::class, 'applications'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);
    $router->get('/dashboard/etudiant/wishlist', [WishlistController::class, 'index'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);
    $router->post('/dashboard/etudiant/wishlist/{offerId}/delete', [WishlistController::class, 'destroy'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/etudiant/candidatures/{id}', [ApplicationController::class, 'showStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);
    $router->get('/dashboard/etudiant/candidatures/{id}/cv', [ApplicationController::class, 'downloadStudentCv'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);
    $router->get('/dashboard/etudiant/profil', [StudentController::class, 'profile'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);
    $router->post('/dashboard/etudiant/profil', [StudentController::class, 'updateProfile'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/etudiant', [StudentController::class, 'dashboard'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['etudiant']),
    ]);

    $router->get('/dashboard/pilote', [PilotController::class, 'dashboard'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/etudiants', [PilotController::class, 'students'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/etudiants/{id}', [PilotController::class, 'showStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/etudiants/{id}/candidatures', [PilotController::class, 'studentApplications'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/candidatures/{id}', [ApplicationController::class, 'showPilot'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/candidatures/{id}/cv', [ApplicationController::class, 'downloadPilotCv'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->get('/dashboard/pilote/etudiants/{id}/edit', [PilotController::class, 'editStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->post('/dashboard/pilote/etudiants/{id}/edit', [PilotController::class, 'updateStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->post('/dashboard/pilote/etudiants/{id}/delete', [PilotController::class, 'deleteStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/pilote/etudiants/create', [PilotController::class, 'createStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
    ]);
    $router->post('/dashboard/pilote/etudiants/create', [PilotController::class, 'storeStudent'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['pilote']),
        new CsrfMiddleware(),
    ]);

    $router->get('/admin/comptes', [AdminController::class, 'accounts'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->get('/admin/comptes/create', [AdminController::class, 'createAccount'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->post('/admin/comptes/create', [AdminController::class, 'storeAccount'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->get('/admin/comptes/{id}/edit', [AdminController::class, 'editAccount'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->post('/admin/comptes/{id}/edit', [AdminController::class, 'updateAccount'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->post('/admin/comptes/{id}/delete', [AdminController::class, 'deleteAccount'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->get('/dashboard/admin', [AdminController::class, 'dashboard'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->get('/admin/entreprises', [CompanyController::class, 'manage'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->get('/admin/entreprises/create', [CompanyController::class, 'create'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->post('/admin/entreprises/create', [CompanyController::class, 'store'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->get('/admin/entreprises/{id}/edit', [CompanyController::class, 'edit'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->post('/admin/entreprises/{id}/edit', [CompanyController::class, 'update'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->post('/admin/entreprises/{id}/delete', [CompanyController::class, 'delete'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->get('/admin/offres', [OfferController::class, 'manage'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->get('/admin/offres/create', [OfferController::class, 'create'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->post('/admin/offres/create', [OfferController::class, 'store'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->get('/admin/offres/{id}/edit', [OfferController::class, 'edit'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
    ]);
    $router->post('/admin/offres/{id}/edit', [OfferController::class, 'update'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
    $router->post('/admin/offres/{id}/delete', [OfferController::class, 'delete'], [
        new AuthenticateMiddleware(),
        new EnsureRoleMiddleware(['administrateur']),
        new CsrfMiddleware(),
    ]);
};
