<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class ApplicationRepository
{
    public function exists(int $applicationId): bool
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM applications
             WHERE id = :id'
        );
        $statement->execute(['id' => $applicationId]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function existsForStudentOffer(int $studentId, int $offerId): bool
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM applications
             WHERE student_id = :student_id AND offer_id = :offer_id'
        );
        $statement->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function create(int $studentId, int $offerId, string $coverLetter, string $cvPath): int
    {
        $statement = $this->pdo()->prepare(
            'INSERT INTO applications (student_id, offer_id, cover_letter, cv_path, status, created_at)
             VALUES (:student_id, :offer_id, :cover_letter, :cv_path, :status, :created_at)'
        );
        $statement->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
            'cover_letter' => $coverLetter,
            'cv_path' => $cvPath,
            'status' => 'envoyee',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->pdo()->lastInsertId();
    }

    public function forStudent(int $studentId): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT applications.id, applications.status, applications.created_at, applications.cv_path,
                    applications.cover_letter, offers.id AS offer_id, offers.title AS offer_title,
                    companies.name AS company_name
             FROM applications
             INNER JOIN offers ON offers.id = applications.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE applications.student_id = :student_id
             ORDER BY applications.created_at DESC'
        );
        $statement->execute(['student_id' => $studentId]);

        return $statement->fetchAll();
    }

    public function recentForStudent(int $studentId, int $limit = 3): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT applications.id, applications.status, applications.created_at,
                    applications.cv_path, offers.title AS offer_title, companies.name AS company_name
             FROM applications
             INNER JOIN offers ON offers.id = applications.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE applications.student_id = :student_id
             ORDER BY applications.created_at DESC
             LIMIT :limit'
        );
        $statement->bindValue(':student_id', $studentId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countForStudent(int $studentId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM applications
             WHERE student_id = :student_id'
        );
        $statement->execute(['student_id' => $studentId]);

        return (int) $statement->fetchColumn();
    }

    public function forPilotStudent(int $pilotPromotionId, int $studentId): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT applications.id, applications.status, applications.created_at, applications.cv_path,
                    applications.cover_letter, offers.id AS offer_id, offers.title AS offer_title,
                    companies.name AS company_name
             FROM applications
             INNER JOIN offers ON offers.id = applications.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             INNER JOIN users ON users.id = applications.student_id
             WHERE applications.student_id = :student_id
               AND users.promotion_id = :promotion_id
             ORDER BY applications.created_at DESC'
        );
        $statement->execute([
            'student_id' => $studentId,
            'promotion_id' => $pilotPromotionId,
        ]);

        return $statement->fetchAll();
    }

    public function findForStudent(int $studentId, int $applicationId): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT applications.id, applications.status, applications.created_at, applications.cv_path,
                    applications.cover_letter, offers.id AS offer_id, offers.title AS offer_title,
                    offers.location AS offer_location, offers.contract_type,
                    companies.id AS company_id, companies.name AS company_name
             FROM applications
             INNER JOIN offers ON offers.id = applications.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE applications.id = :application_id AND applications.student_id = :student_id
             LIMIT 1'
        );
        $statement->execute([
            'application_id' => $applicationId,
            'student_id' => $studentId,
        ]);
        $application = $statement->fetch();

        return is_array($application) ? $application : null;
    }

    public function findForPilot(int $promotionId, int $applicationId): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT applications.id, applications.status, applications.created_at, applications.cv_path,
                    applications.cover_letter, offers.id AS offer_id, offers.title AS offer_title,
                    offers.location AS offer_location, offers.contract_type,
                    companies.id AS company_id, companies.name AS company_name,
                    users.id AS student_id, users.first_name AS student_first_name, users.last_name AS student_last_name
             FROM applications
             INNER JOIN offers ON offers.id = applications.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             INNER JOIN users ON users.id = applications.student_id
             WHERE applications.id = :application_id AND users.promotion_id = :promotion_id
             LIMIT 1'
        );
        $statement->execute([
            'application_id' => $applicationId,
            'promotion_id' => $promotionId,
        ]);
        $application = $statement->fetch();

        return is_array($application) ? $application : null;
    }

    public function countForPromotion(int $promotionId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM applications
             INNER JOIN users ON users.id = applications.student_id
             WHERE users.promotion_id = :promotion_id'
        );
        $statement->execute(['promotion_id' => $promotionId]);

        return (int) $statement->fetchColumn();
    }

    public function countForPromotionStudent(int $promotionId, int $studentId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM applications
             INNER JOIN users ON users.id = applications.student_id
             WHERE users.promotion_id = :promotion_id
               AND applications.student_id = :student_id'
        );
        $statement->execute([
            'promotion_id' => $promotionId,
            'student_id' => $studentId,
        ]);

        return (int) $statement->fetchColumn();
    }

    public function recentForPromotion(int $promotionId, int $limit = 5): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT applications.id, applications.status, applications.created_at,
                    offers.title AS offer_title, companies.name AS company_name,
                    users.id AS student_id, users.first_name AS student_first_name, users.last_name AS student_last_name
             FROM applications
             INNER JOIN users ON users.id = applications.student_id
             INNER JOIN offers ON offers.id = applications.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE users.promotion_id = :promotion_id
             ORDER BY applications.created_at DESC
             LIMIT :limit'
        );
        $statement->bindValue(':promotion_id', $promotionId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }
}
