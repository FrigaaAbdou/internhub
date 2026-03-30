<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class PromotionRepository
{
    public function all(): array
    {
        $statement = $this->pdo()->query(
            'SELECT id, name
             FROM promotions
             ORDER BY name ASC'
        );

        return $statement->fetchAll();
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }
}
