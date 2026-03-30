<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Exceptions\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\ApplicationRepository;
use App\Models\UserRepository;

final class PilotController extends Controller
{
    public function __construct(
        private readonly UserRepository $users = new UserRepository(),
        private readonly ApplicationRepository $applications = new ApplicationRepository(),
    ) {
    }

    public function dashboard(Request $request): Response
    {
        $promotionId = (int) (Auth::user()['promotion_id'] ?? 0);
        $students = $this->users->listStudentsByPromotion($promotionId);

        return $this->view('pilot/dashboard', [
            'studentCount' => count($students),
            'applicationCount' => $this->applications->countForPromotion($promotionId),
            'recentApplications' => $this->applications->recentForPromotion($promotionId, 5),
        ]);
    }

    public function students(Request $request): Response
    {
        $promotionId = (int) (Auth::user()['promotion_id'] ?? 0);

        return $this->view('pilot/students', [
            'students' => $this->users->listStudentsByPromotion($promotionId),
        ]);
    }

    public function studentApplications(Request $request): Response
    {
        $student = $this->findStudentInPromotion((int) $request->route('id'));
        $promotionId = (int) (Auth::user()['promotion_id'] ?? 0);

        return $this->view('pilot/student-applications', [
            'student' => $student,
            'applications' => $this->applications->forPilotStudent($promotionId, (int) $student['id']),
        ]);
    }

    public function showStudent(Request $request): Response
    {
        $student = $this->findStudentInPromotion((int) $request->route('id'));
        $promotionId = (int) (Auth::user()['promotion_id'] ?? 0);
        $applications = $this->applications->forPilotStudent($promotionId, (int) $student['id']);

        return $this->view('pilot/show-student', [
            'student' => $student,
            'applicationCount' => $this->applications->countForPromotionStudent($promotionId, (int) $student['id']),
            'recentApplications' => array_slice($applications, 0, 3),
        ]);
    }

    public function createStudent(Request $request): Response
    {
        return $this->view('pilot/create-student', [
            'errors' => [],
            'values' => [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'promotion_id' => (string) (Auth::user()['promotion_id'] ?? ''),
            ],
        ]);
    }

    public function editStudent(Request $request): Response
    {
        $student = $this->findStudentInPromotion((int) $request->route('id'));

        return $this->view('pilot/edit-student', [
            'errors' => [],
            'values' => [
                'id' => (string) $student['id'],
                'first_name' => (string) $student['first_name'],
                'last_name' => (string) $student['last_name'],
                'email' => (string) $student['email'],
                'promotion_id' => (string) ($student['promotion_id'] ?? ''),
                'password' => '',
            ],
        ]);
    }

    public function storeStudent(Request $request): Response
    {
        $values = [
            'first_name' => trim((string) $request->input('first_name', '')),
            'last_name' => trim((string) $request->input('last_name', '')),
            'email' => trim((string) $request->input('email', '')),
            'promotion_id' => (string) (Auth::user()['promotion_id'] ?? ''),
        ];
        $password = (string) $request->input('password', '');
        $errors = [];

        if ($values['first_name'] === '') {
            $errors['first_name'] = 'Le prenom est requis.';
        }

        if ($values['last_name'] === '') {
            $errors['last_name'] = 'Le nom est requis.';
        }

        if ($values['email'] === '' || ! filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Merci de saisir un email valide.';
        } elseif ($this->users->emailExists($values['email'])) {
            $errors['email'] = 'Cet email est deja utilise.';
        }

        if (strlen($password) < 8) {
            $errors['password'] = 'Le mot de passe initial doit contenir au moins 8 caracteres.';
        }

        if ($errors !== []) {
            return $this->view('pilot/create-student', [
                'errors' => $errors,
                'values' => $values,
            ], 422);
        }

        $this->users->createStudent(
            $values['first_name'],
            $values['last_name'],
            $values['email'],
            $password,
            (int) $values['promotion_id'],
        );

        Session::flash('success', 'Le compte etudiant a bien ete cree.');

        return $this->redirect('/dashboard/pilote/etudiants');
    }

    public function updateStudent(Request $request): Response
    {
        $student = $this->findStudentInPromotion((int) $request->route('id'));
        $values = [
            'id' => (string) $student['id'],
            'first_name' => trim((string) $request->input('first_name', '')),
            'last_name' => trim((string) $request->input('last_name', '')),
            'email' => trim((string) $request->input('email', '')),
            'promotion_id' => (string) ($student['promotion_id'] ?? ''),
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
        } elseif ($this->users->emailExists($values['email'], (int) $student['id'])) {
            $errors['email'] = 'Cet email est deja utilise.';
        }

        if ($values['password'] !== '' && strlen($values['password']) < 8) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 8 caracteres.';
        }

        if ($errors !== []) {
            return $this->view('pilot/edit-student', [
                'errors' => $errors,
                'values' => $values,
            ], 422);
        }

        $this->users->updateAccount(
            (int) $student['id'],
            $values['first_name'],
            $values['last_name'],
            $values['email'],
            'etudiant',
            (int) $values['promotion_id'],
            $values['password'] === '' ? null : $values['password'],
        );
        Session::flash('success', 'Le compte etudiant a bien ete mis a jour.');

        return $this->redirect('/dashboard/pilote/etudiants');
    }

    public function deleteStudent(Request $request): Response
    {
        $student = $this->findStudentInPromotion((int) $request->route('id'));
        $this->users->deleteAccount((int) $student['id']);
        Session::flash('success', 'Le compte etudiant a bien ete supprime.');

        return $this->redirect('/dashboard/pilote/etudiants');
    }

    private function findStudentInPromotion(int $studentId): array
    {
        $promotionId = (int) (Auth::user()['promotion_id'] ?? 0);
        $student = $this->users->findById($studentId);

        if (
            ! is_array($student)
            || (string) ($student['role'] ?? '') !== 'etudiant'
            || (int) ($student['promotion_id'] ?? 0) !== $promotionId
        ) {
            throw HttpException::forbidden('Cet etudiant n appartient pas a votre promotion.');
        }

        return $student;
    }
}
