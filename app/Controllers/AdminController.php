<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Exceptions\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\CompanyRepository;
use App\Models\OfferRepository;
use App\Models\PromotionRepository;
use App\Models\UserRepository;

final class AdminController extends Controller
{
    public function __construct(
        private readonly UserRepository $users = new UserRepository(),
        private readonly PromotionRepository $promotions = new PromotionRepository(),
        private readonly CompanyRepository $companies = new CompanyRepository(),
        private readonly OfferRepository $offers = new OfferRepository(),
    ) {
    }

    public function dashboard(Request $request): Response
    {
        return $this->view('admin/dashboard', [
            'pilotCount' => $this->users->countByRole('pilote'),
            'studentCount' => $this->users->countByRole('etudiant'),
            'companyCount' => $this->companies->countAll(),
            'publishedOfferCount' => $this->offers->countPublished(),
        ]);
    }

    public function accounts(Request $request): Response
    {
        return $this->view('admin/accounts', [
            'accounts' => $this->users->listManageableAccounts(),
        ]);
    }

    public function createAccount(Request $request): Response
    {
        return $this->view('admin/account-form', [
            'mode' => 'create',
            'errors' => [],
            'values' => $this->defaultValues(),
            'promotions' => $this->promotions->all(),
            'formAction' => '/admin/comptes/create',
            'title' => 'Creer un compte',
        ]);
    }

    public function storeAccount(Request $request): Response
    {
        [$values, $errors] = $this->validateAccountPayload($request);

        if ($errors !== []) {
            return $this->view('admin/account-form', [
                'mode' => 'create',
                'errors' => $errors,
                'values' => $values,
                'promotions' => $this->promotions->all(),
                'formAction' => '/admin/comptes/create',
                'title' => 'Creer un compte',
            ], 422);
        }

        $this->persistAccount($values);
        Session::flash('success', 'Le compte a bien ete cree.');

        return $this->redirect('/admin/comptes');
    }

    public function editAccount(Request $request): Response
    {
        $account = $this->findManageableAccount((int) $request->route('id'));

        return $this->view('admin/account-form', [
            'mode' => 'edit',
            'errors' => [],
            'values' => [
                'id' => (string) $account['id'],
                'first_name' => (string) $account['first_name'],
                'last_name' => (string) $account['last_name'],
                'email' => (string) $account['email'],
                'role' => (string) $account['role'],
                'promotion_id' => (string) ($account['promotion_id'] ?? ''),
                'password' => '',
            ],
            'promotions' => $this->promotions->all(),
            'formAction' => '/admin/comptes/' . $account['id'] . '/edit',
            'title' => 'Modifier un compte',
        ]);
    }

    public function updateAccount(Request $request): Response
    {
        $account = $this->findManageableAccount((int) $request->route('id'));
        [$values, $errors] = $this->validateAccountPayload($request, (int) $account['id'], true);
        $values['id'] = (string) $account['id'];

        if ($errors !== []) {
            return $this->view('admin/account-form', [
                'mode' => 'edit',
                'errors' => $errors,
                'values' => $values,
                'promotions' => $this->promotions->all(),
                'formAction' => '/admin/comptes/' . $account['id'] . '/edit',
                'title' => 'Modifier un compte',
            ], 422);
        }

        $this->users->updateAccount(
            (int) $account['id'],
            $values['first_name'],
            $values['last_name'],
            $values['email'],
            $values['role'],
            $values['promotion_id'] === '' ? null : (int) $values['promotion_id'],
            $values['password'] === '' ? null : $values['password'],
        );
        Session::flash('success', 'Le compte a bien ete mis a jour.');

        return $this->redirect('/admin/comptes');
    }

    public function deleteAccount(Request $request): Response
    {
        $account = $this->findManageableAccount((int) $request->route('id'));
        $this->users->deleteAccount((int) $account['id']);
        Session::flash('success', 'Le compte a bien ete supprime.');

        return $this->redirect('/admin/comptes');
    }

    private function validateAccountPayload(Request $request, ?int $exceptId = null, bool $isEdit = false): array
    {
        $values = [
            'first_name' => trim((string) $request->input('first_name', '')),
            'last_name' => trim((string) $request->input('last_name', '')),
            'email' => trim((string) $request->input('email', '')),
            'role' => trim((string) $request->input('role', '')),
            'promotion_id' => trim((string) $request->input('promotion_id', '')),
            'password' => (string) $request->input('password', ''),
        ];
        $errors = [];

        if ($values['first_name'] === '') {
            $errors['first_name'] = 'Le prenom est requis.';
        }

        if ($values['last_name'] === '') {
            $errors['last_name'] = 'Le nom est requis.';
        }

        if ($values['email'] === '' || ! filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Merci de saisir un email valide.';
        } elseif ($this->users->emailExists($values['email'], $exceptId)) {
            $errors['email'] = 'Cet email est deja utilise.';
        }

        if (! in_array($values['role'], ['pilote', 'etudiant'], true)) {
            $errors['role'] = 'Le role doit etre pilote ou etudiant.';
        }

        if ($values['promotion_id'] === '' || ! ctype_digit($values['promotion_id'])) {
            $errors['promotion_id'] = 'Une promotion valide est requise.';
        }

        if (! $isEdit && strlen($values['password']) < 8) {
            $errors['password'] = 'Le mot de passe initial doit contenir au moins 8 caracteres.';
        }

        if ($isEdit && $values['password'] !== '' && strlen($values['password']) < 8) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 8 caracteres.';
        }

        return [$values, $errors];
    }

    private function persistAccount(array $values): void
    {
        if ($values['role'] === 'pilote') {
            $this->users->createPilot(
                $values['first_name'],
                $values['last_name'],
                $values['email'],
                $values['password'],
                (int) $values['promotion_id'],
            );

            return;
        }

        $this->users->createStudent(
            $values['first_name'],
            $values['last_name'],
            $values['email'],
            $values['password'],
            (int) $values['promotion_id'],
        );
    }

    private function findManageableAccount(int $id): array
    {
        $account = $this->users->findById($id);

        if (! is_array($account) || ! in_array((string) $account['role'], ['pilote', 'etudiant'], true)) {
            throw HttpException::notFound();
        }

        return $account;
    }

    private function defaultValues(): array
    {
        return [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'role' => 'etudiant',
            'promotion_id' => '',
            'password' => '',
        ];
    }
}
