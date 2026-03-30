<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class WishlistRepository
{
    public function exists(int $studentId, int $offerId): bool
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM wishlists
             WHERE student_id = :student_id AND offer_id = :offer_id'
        );
        $statement->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function add(int $studentId, int $offerId): void
    {
        $statement = $this->pdo()->prepare(
            'INSERT OR IGNORE INTO wishlists (student_id, offer_id, created_at)
             VALUES (:student_id, :offer_id, :created_at)'
        );
        $statement->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function remove(int $studentId, int $offerId): void
    {
        $statement = $this->pdo()->prepare(
            'DELETE FROM wishlists
             WHERE student_id = :student_id AND offer_id = :offer_id'
        );
        $statement->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);
    }

    public function forStudent(int $studentId): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT wishlists.offer_id, wishlists.created_at,
                    offers.title, offers.location, offers.contract_type,
                    companies.name AS company_name
             FROM wishlists
             INNER JOIN offers ON offers.id = wishlists.offer_id
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE wishlists.student_id = :student_id AND offers.is_published = 1
             ORDER BY wishlists.created_at DESC'
        );
        $statement->execute(['student_id' => $studentId]);

        return $statement->fetchAll();
    }

    public function countForStudent(int $studentId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM wishlists
             WHERE student_id = :student_id'
        );
        $statement->execute(['student_id' => $studentId]);

        return (int) $statement->fetchColumn();
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }
}
