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

final class ApplicationController extends Controller
{
    private const MAX_CV_SIZE = 2_000_000;

    public function __construct(
        private readonly OfferRepository $offers = new OfferRepository(),
        private readonly ApplicationRepository $applications = new ApplicationRepository(),
    ) {
    }

    public function create(Request $request): Response
    {
        $offer = $this->offers->find((int) $request->route('id'));

        if (! is_array($offer)) {
            $this->abort(404);
        }

        $studentId = (int) Auth::id();

        if ($this->applications->existsForStudentOffer($studentId, (int) $offer['id'])) {
            Session::flash('error', 'Vous avez deja candidate a cette offre.');

            return $this->redirect('/dashboard/etudiant/candidatures');
        }

        return $this->view('student/create-application', [
            'offer' => $offer,
            'errors' => [],
            'coverLetter' => '',
        ]);
    }

    public function store(Request $request): Response
    {
        $offer = $this->offers->find((int) $request->route('id'));

        if (! is_array($offer)) {
            $this->abort(404);
        }

        $studentId = (int) Auth::id();
        $coverLetter = trim((string) $request->input('cover_letter', ''));
        $cvFile = $request->file('cv');
        $errors = [];

        if ($this->applications->existsForStudentOffer($studentId, (int) $offer['id'])) {
            Session::flash('error', 'Une candidature existe deja pour cette offre.');

            return $this->redirect('/dashboard/etudiant/candidatures');
        }

        if (mb_strlen($coverLetter) < 40) {
            $errors['cover_letter'] = 'Merci de fournir une lettre de motivation plus detaillee.';
        }

        if (! is_array($cvFile) || (int) ($cvFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            $errors['cv'] = 'Merci de joindre votre CV au format PDF.';
        } elseif ((int) $cvFile['error'] !== UPLOAD_ERR_OK) {
            $errors['cv'] = 'Le televersement du CV a echoue. Merci de reessayer.';
        } else {
            $extension = strtolower(pathinfo((string) $cvFile['name'], PATHINFO_EXTENSION));
            $size = (int) ($cvFile['size'] ?? 0);

            if ($extension !== 'pdf') {
                $errors['cv'] = 'Le CV doit etre fourni au format PDF.';
            } elseif ($size > self::MAX_CV_SIZE) {
                $errors['cv'] = 'Le CV ne doit pas depasser 2 Mo.';
            }
        }

        if ($errors !== []) {
            return $this->view('student/create-application', [
                'offer' => $offer,
                'errors' => $errors,
                'coverLetter' => $coverLetter,
            ], 422);
        }

        $cvPath = $this->storeCv($studentId, (int) $offer['id'], $cvFile);
        $this->applications->create($studentId, (int) $offer['id'], $coverLetter, $cvPath);
        Session::flash('success', 'Votre candidature a bien ete envoyee.');

        return $this->redirect('/dashboard/etudiant/candidatures');
    }

    public function showStudent(Request $request): Response
    {
        $application = $this->findStudentApplication((int) $request->route('id'));

        return $this->view('student/show-application', [
            'application' => $application,
        ]);
    }

    public function downloadStudentCv(Request $request): Response
    {
        $application = $this->findStudentApplication((int) $request->route('id'));

        return $this->downloadCvResponse($application);
    }

    public function showPilot(Request $request): Response
    {
        $application = $this->findPilotApplication((int) $request->route('id'));

        return $this->view('pilot/show-application', [
            'application' => $application,
        ]);
    }

    public function downloadPilotCv(Request $request): Response
    {
        $application = $this->findPilotApplication((int) $request->route('id'));

        return $this->downloadCvResponse($application);
    }

    private function storeCv(int $studentId, int $offerId, array $cvFile): string
    {
        $targetDirectory = dirname(__DIR__, 2) . '/storage/uploads/cv';

        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0775, true);
        }

        $filename = sprintf(
            'cv-student-%d-offer-%d-%s.pdf',
            $studentId,
            $offerId,
            bin2hex(random_bytes(6)),
        );
        $targetPath = $targetDirectory . '/' . $filename;
        $tmpName = (string) $cvFile['tmp_name'];

        $moved = is_uploaded_file($tmpName)
            ? move_uploaded_file($tmpName, $targetPath)
            : rename($tmpName, $targetPath);

        if (! $moved) {
            throw new \RuntimeException('Impossible de stocker le CV televerse.');
        }

        return 'uploads/cv/' . $filename;
    }

    private function findStudentApplication(int $applicationId): array
    {
        $studentId = (int) Auth::id();
        $application = $this->applications->findForStudent($studentId, $applicationId);

        if (is_array($application)) {
            return $application;
        }

        if ($this->applications->exists($applicationId)) {
            $this->abort(403, 'Cette candidature ne vous appartient pas.');
        }

        $this->abort(404);
    }

    private function findPilotApplication(int $applicationId): array
    {
        $promotionId = (int) (Auth::user()['promotion_id'] ?? 0);
        $application = $this->applications->findForPilot($promotionId, $applicationId);

        if (is_array($application)) {
            return $application;
        }

        if ($this->applications->exists($applicationId)) {
            $this->abort(403, 'Cette candidature n appartient pas a votre promotion.');
        }

        $this->abort(404);
    }

    private function downloadCvResponse(array $application): Response
    {
        $relativePath = (string) ($application['cv_path'] ?? '');

        if ($relativePath === '') {
            $this->abort(404, 'Aucun CV n est disponible pour cette candidature.');
        }

        $absolutePath = dirname(__DIR__, 2) . '/storage/' . ltrim($relativePath, '/');

        if (! is_file($absolutePath)) {
            $this->abort(404, 'Le fichier demande est introuvable.');
        }

        $content = file_get_contents($absolutePath);

        if ($content === false) {
            throw new \RuntimeException('Impossible de lire le CV stocke.');
        }

        return Response::download(
            $content,
            basename($absolutePath),
            'application/pdf',
        );
    }
}
