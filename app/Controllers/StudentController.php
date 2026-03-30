<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\ApplicationRepository;
use App\Models\OfferRepository;
use App\Models\CompanyRepository;
use App\Models\UserRepository;
use App\Models\WishlistRepository;

final class StudentController extends Controller
{
    public function __construct(
        private readonly ApplicationRepository $applications = new ApplicationRepository(),
        private readonly OfferRepository $offers = new OfferRepository(),
        private readonly CompanyRepository $companies = new CompanyRepository(),
        private readonly UserRepository $users = new UserRepository(),
        private readonly WishlistRepository $wishlists = new WishlistRepository(),
    ) {
    }

    public function dashboard(Request $request): Response
    {
        $studentId = (int) Auth::id();

        return $this->view('student/dashboard', [
            'applicationCount' => $this->applications->countForStudent($studentId),
            'recentApplications' => $this->applications->recentForStudent($studentId, 3),
            'publishedOfferCount' => $this->offers->countPublished(),
            'companyCount' => $this->companies->countAll(),
            'wishlistCount' => $this->wishlists->countForStudent($studentId),
            'student' => Auth::user(),
        ]);
    }

    public function applications(Request $request): Response
    {
        return $this->view('student/applications', [
            'applications' => $this->applications->forStudent((int) Auth::id()),
        ]);
    }

    public function profile(Request $request): Response
    {
        $student = $this->currentStudent();

        return $this->view('student/profile', [
            'errors' => [],
            'values' => $this->profileValues($student),
        ]);
    }

    public function updateProfile(Request $request): Response
    {
        $student = $this->currentStudent();
        [$values, $errors] = $this->validateProfilePayload($request, (int) $student['id']);

        if ($errors !== []) {
            return $this->view('student/profile', [
                'errors' => $errors,
                'values' => array_replace($this->profileValues($student), $values),
            ], 422);
        }

        $this->users->updateAccount(
            (int) $student['id'],
            $values['first_name'],
            $values['last_name'],
            $values['email'],
            'etudiant',
            $student['promotion_id'] === null ? null : (int) $student['promotion_id'],
            $values['password'] === '' ? null : $values['password'],
        );

        $updatedStudent = $this->currentStudent();
        Auth::login([
            'id' => (int) $updatedStudent['id'],
            'first_name' => (string) $updatedStudent['first_name'],
            'last_name' => (string) $updatedStudent['last_name'],
            'email' => (string) $updatedStudent['email'],
            'role' => (string) $updatedStudent['role'],
            'promotion_id' => $updatedStudent['promotion_id'] === null ? null : (int) $updatedStudent['promotion_id'],
        ]);
        Session::flash('success', 'Votre profil a bien ete mis a jour.');

        return $this->redirect('/dashboard/etudiant/profil');
    }

    private function currentStudent(): array
    {
        $student = $this->users->findByIdWithPromotion((int) Auth::id());

        if (! is_array($student) || (string) ($student['role'] ?? '') !== 'etudiant') {
            $this->abort(403);
        }

        return $student;
    }

    private function profileValues(array $student): array
    {
        return [
            'id' => (string) $student['id'],
            'first_name' => (string) $student['first_name'],
            'last_name' => (string) $student['last_name'],
            'email' => (string) $student['email'],
            'role' => 'etudiant',
            'promotion_name' => (string) ($student['promotion_name'] ?? ''),
            'password' => '',
        ];
    }

    private function validateProfilePayload(Request $request, int $studentId): array
    {
        $values = [
            'first_name' => trim((string) $request->input('first_name', '')),
            'last_name' => trim((string) $request->input('last_name', '')),
            'email' => trim((string) $request->input('email', '')),
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
        } elseif ($this->users->emailExists($values['email'], $studentId)) {
            $errors['email'] = 'Cet email est deja utilise.';
        }

        if ($values['password'] !== '' && strlen($values['password']) < 8) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 8 caracteres.';
        }

        return [$values, $errors];
    }
}
