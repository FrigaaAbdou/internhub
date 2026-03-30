<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class OfferRepository
{
    public function paginate(int $page, int $perPage, array $filters = []): array
    {
        [$whereClause, $bindings] = $this->buildFilters($filters);

        $count = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM offers
             INNER JOIN companies ON companies.id = offers.company_id
             ' . $whereClause
        );
        $count->execute($bindings);
        $total = (int) $count->fetchColumn();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $currentPage = min(max(1, $page), $lastPage);
        $offset = ($currentPage - 1) * $perPage;

        $query = 'SELECT offers.id, offers.title, offers.location, offers.contract_type, offers.description,
                         offers.created_at,
                         companies.id AS company_id, companies.name AS company_name
                  FROM offers
                  INNER JOIN companies ON companies.id = offers.company_id
                  ' . $whereClause . '
                  ORDER BY offers.created_at DESC
                  LIMIT :limit OFFSET :offset';

        $statement = $this->pdo()->prepare($query);

        foreach ($bindings as $key => $value) {
            $statement->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }

        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return [
            'data' => $statement->fetchAll(),
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
        ];
    }

    public function filterOptions(): array
    {
        $locations = $this->pdo()->query(
            'SELECT DISTINCT location
             FROM offers
             WHERE is_published = 1
             ORDER BY location ASC'
        )->fetchAll(PDO::FETCH_COLUMN);

        $contractTypes = $this->pdo()->query(
            'SELECT DISTINCT contract_type
             FROM offers
             WHERE is_published = 1
             ORDER BY contract_type ASC'
        )->fetchAll(PDO::FETCH_COLUMN);

        return [
            'locations' => array_values(array_filter($locations, 'is_string')),
            'contractTypes' => array_values(array_filter($contractTypes, 'is_string')),
        ];
    }

    public function paginateForManagement(int $page, int $perPage, string $search = ''): array
    {
        $filters = '';
        $bindings = [];

        if ($search !== '') {
            $filters = 'WHERE offers.title LIKE :search OR companies.name LIKE :search OR offers.location LIKE :search';
            $bindings['search'] = '%' . $search . '%';
        }

        $count = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM offers
             INNER JOIN companies ON companies.id = offers.company_id
             ' . $filters
        );
        $count->execute($bindings);
        $total = (int) $count->fetchColumn();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $currentPage = min(max(1, $page), $lastPage);
        $offset = ($currentPage - 1) * $perPage;

        $query = 'SELECT offers.id, offers.title, offers.location, offers.contract_type, offers.description,
                         offers.company_id, offers.is_published, companies.name AS company_name,
                         COUNT(applications.id) AS application_count
                  FROM offers
                  INNER JOIN companies ON companies.id = offers.company_id
                  LEFT JOIN applications ON applications.offer_id = offers.id
                  ' . $filters . '
                  GROUP BY offers.id, offers.title, offers.location, offers.contract_type, offers.description,
                           offers.company_id, offers.is_published, companies.name
                  ORDER BY offers.created_at DESC
                  LIMIT :limit OFFSET :offset';

        $statement = $this->pdo()->prepare($query);

        foreach ($bindings as $key => $value) {
            $statement->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }

        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return [
            'data' => $statement->fetchAll(),
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
        ];
    }

    public function find(int $id): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT offers.id, offers.title, offers.location, offers.contract_type, offers.description,
                    offers.company_id, offers.is_published, offers.created_at,
                    companies.name AS company_name, companies.website AS company_website,
                    companies.city AS company_city, companies.description AS company_description
             FROM offers
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE offers.id = :id AND offers.is_published = 1
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $offer = $statement->fetch();

        return is_array($offer) ? $offer : null;
    }

    public function findRelated(int $companyId, int $excludeOfferId, int $limit = 3): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT offers.id, offers.title, offers.location, offers.contract_type, offers.description,
                    offers.created_at
             FROM offers
             WHERE offers.company_id = :company_id
               AND offers.is_published = 1
               AND offers.id != :exclude_offer_id
             ORDER BY offers.created_at DESC
             LIMIT :limit'
        );
        $statement->bindValue(':company_id', $companyId, PDO::PARAM_INT);
        $statement->bindValue(':exclude_offer_id', $excludeOfferId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function findForManagement(int $id): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT offers.id, offers.title, offers.location, offers.contract_type, offers.description,
                    offers.company_id, offers.is_published, companies.name AS company_name
             FROM offers
             INNER JOIN companies ON companies.id = offers.company_id
             WHERE offers.id = :id
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $offer = $statement->fetch();

        return is_array($offer) ? $offer : null;
    }

    public function create(
        int $companyId,
        string $title,
        string $location,
        string $contractType,
        string $description,
        bool $isPublished,
    ): int {
        $statement = $this->pdo()->prepare(
            'INSERT INTO offers (company_id, title, location, contract_type, description, is_published, created_at)
             VALUES (:company_id, :title, :location, :contract_type, :description, :is_published, :created_at)'
        );
        $statement->execute([
            'company_id' => $companyId,
            'title' => $title,
            'location' => $location,
            'contract_type' => $contractType,
            'description' => $description,
            'is_published' => $isPublished ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->pdo()->lastInsertId();
    }

    public function update(
        int $id,
        int $companyId,
        string $title,
        string $location,
        string $contractType,
        string $description,
        bool $isPublished,
    ): void {
        $statement = $this->pdo()->prepare(
            'UPDATE offers
             SET company_id = :company_id,
                 title = :title,
                 location = :location,
                 contract_type = :contract_type,
                 description = :description,
                 is_published = :is_published
             WHERE id = :id'
        );
        $statement->execute([
            'id' => $id,
            'company_id' => $companyId,
            'title' => $title,
            'location' => $location,
            'contract_type' => $contractType,
            'description' => $description,
            'is_published' => $isPublished ? 1 : 0,
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo()->prepare('DELETE FROM offers WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function countApplications(int $offerId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM applications
             WHERE offer_id = :offer_id'
        );
        $statement->execute(['offer_id' => $offerId]);

        return (int) $statement->fetchColumn();
    }

    public function countPublished(): int
    {
        return (int) $this->pdo()->query(
            'SELECT COUNT(*)
             FROM offers
             WHERE is_published = 1'
        )->fetchColumn();
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }

    private function buildFilters(array $filters): array
    {
        $where = ['offers.is_published = 1'];
        $bindings = [];

        $search = trim((string) ($filters['q'] ?? ''));
        if ($search !== '') {
            $where[] = '(offers.title LIKE :search OR companies.name LIKE :search OR offers.location LIKE :search)';
            $bindings['search'] = '%' . $search . '%';
        }

        $location = trim((string) ($filters['location'] ?? ''));
        if ($location !== '') {
            $where[] = 'offers.location = :location';
            $bindings['location'] = $location;
        }

        $contractType = trim((string) ($filters['contract_type'] ?? ''));
        if ($contractType !== '') {
            $where[] = 'offers.contract_type = :contract_type';
            $bindings['contract_type'] = $contractType;
        }

        return ['WHERE ' . implode(' AND ', $where), $bindings];
    }
}
