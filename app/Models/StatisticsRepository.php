<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class StatisticsRepository
{
    public function overview(): array
    {
        $publishedOfferCount = $this->publishedOfferCount();
        $applicationCount = $this->applicationCount();

        return [
            'publishedOfferCount' => $publishedOfferCount,
            'companyCount' => $this->companyCount(),
            'applicationCount' => $applicationCount,
            'averageApplicationsPerOffer' => $publishedOfferCount > 0
                ? round($applicationCount / $publishedOfferCount, 1)
                : 0.0,
            'topLocations' => $this->publishedOffersByLocation(),
            'topContractTypes' => $this->publishedOffersByContractType(),
            'applicationStatuses' => $this->applicationsByStatus(),
        ];
    }

    private function publishedOfferCount(): int
    {
        return (int) $this->pdo()->query(
            'SELECT COUNT(*)
             FROM offers
             WHERE is_published = 1'
        )->fetchColumn();
    }

    private function companyCount(): int
    {
        return (int) $this->pdo()->query(
            'SELECT COUNT(*)
             FROM companies'
        )->fetchColumn();
    }

    private function applicationCount(): int
    {
        return (int) $this->pdo()->query(
            'SELECT COUNT(*)
             FROM applications'
        )->fetchColumn();
    }

    private function publishedOffersByLocation(): array
    {
        $statement = $this->pdo()->query(
            'SELECT location AS label, COUNT(*) AS total
             FROM offers
             WHERE is_published = 1
             GROUP BY location
             ORDER BY total DESC, location ASC
             LIMIT 5'
        );

        return $statement->fetchAll();
    }

    private function publishedOffersByContractType(): array
    {
        $statement = $this->pdo()->query(
            'SELECT contract_type AS label, COUNT(*) AS total
             FROM offers
             WHERE is_published = 1
             GROUP BY contract_type
             ORDER BY total DESC, contract_type ASC
             LIMIT 5'
        );

        return $statement->fetchAll();
    }

    private function applicationsByStatus(): array
    {
        $statement = $this->pdo()->query(
            'SELECT status AS label, COUNT(*) AS total
             FROM applications
             GROUP BY status
             ORDER BY total DESC, status ASC
             LIMIT 5'
        );

        return $statement->fetchAll();
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }
}
