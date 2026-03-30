<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class CompanyRepository
{
    public function paginate(int $page, int $perPage, string $search = ''): array
    {
        $filters = '';
        $bindings = [];

        if ($search !== '') {
            $filters = 'WHERE companies.name LIKE :search OR companies.city LIKE :search OR companies.industry LIKE :search';
            $bindings['search'] = '%' . $search . '%';
        }

        $count = $this->pdo()->prepare('SELECT COUNT(*) FROM companies ' . $filters);
        $count->execute($bindings);
        $total = (int) $count->fetchColumn();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $currentPage = min(max(1, $page), $lastPage);
        $offset = ($currentPage - 1) * $perPage;

        $query = 'SELECT companies.id, companies.name, companies.industry, companies.city, companies.website,
                         companies.description, COUNT(offers.id) AS offer_count
                  FROM companies
                  LEFT JOIN offers ON offers.company_id = companies.id AND offers.is_published = 1
                  ' . $filters . '
                  GROUP BY companies.id, companies.name, companies.industry, companies.city, companies.website, companies.description
                  ORDER BY companies.name ASC
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

    public function publicFacets(): array
    {
        $cities = $this->pdo()->query(
            'SELECT DISTINCT city
             FROM companies
             WHERE city IS NOT NULL AND city != \'\'
             ORDER BY city ASC'
        )->fetchAll(PDO::FETCH_COLUMN);

        $industries = $this->pdo()->query(
            'SELECT DISTINCT industry
             FROM companies
             WHERE industry IS NOT NULL AND industry != \'\'
             ORDER BY industry ASC'
        )->fetchAll(PDO::FETCH_COLUMN);

        $cityCount = (int) $this->pdo()->query(
            'SELECT COUNT(DISTINCT city)
             FROM companies
             WHERE city IS NOT NULL AND city != \'\''
        )->fetchColumn();

        $industryCount = (int) $this->pdo()->query(
            'SELECT COUNT(DISTINCT industry)
             FROM companies
             WHERE industry IS NOT NULL AND industry != \'\''
        )->fetchColumn();

        return [
            'cities' => array_values(array_filter($cities, 'is_string')),
            'industries' => array_values(array_filter($industries, 'is_string')),
            'cityCount' => $cityCount,
            'industryCount' => $industryCount,
        ];
    }

    public function paginateForManagement(int $page, int $perPage, string $search = ''): array
    {
        $filters = '';
        $bindings = [];

        if ($search !== '') {
            $filters = 'WHERE companies.name LIKE :search OR companies.city LIKE :search OR companies.industry LIKE :search';
            $bindings['search'] = '%' . $search . '%';
        }

        $count = $this->pdo()->prepare('SELECT COUNT(*) FROM companies ' . $filters);
        $count->execute($bindings);
        $total = (int) $count->fetchColumn();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $currentPage = min(max(1, $page), $lastPage);
        $offset = ($currentPage - 1) * $perPage;

        $query = 'SELECT companies.id, companies.name, companies.industry, companies.city, companies.website,
                         companies.description, COUNT(offers.id) AS offer_count
                  FROM companies
                  LEFT JOIN offers ON offers.company_id = companies.id
                  ' . $filters . '
                  GROUP BY companies.id, companies.name, companies.industry, companies.city, companies.website, companies.description
                  ORDER BY companies.name ASC
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
            'SELECT id, name, industry, city, website, description
             FROM companies
             WHERE id = :id
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $company = $statement->fetch();

        if (! is_array($company)) {
            return null;
        }

        $offers = $this->pdo()->prepare(
            'SELECT id, title, location, contract_type
             FROM offers
             WHERE company_id = :company_id AND is_published = 1
             ORDER BY created_at DESC'
        );
        $offers->execute(['company_id' => $id]);
        $company['offers'] = $offers->fetchAll();

        return $company;
    }

    public function create(
        string $name,
        string $industry,
        string $city,
        ?string $website,
        string $description,
    ): int {
        $statement = $this->pdo()->prepare(
            'INSERT INTO companies (name, industry, city, website, description, created_at)
             VALUES (:name, :industry, :city, :website, :description, :created_at)'
        );
        $statement->execute([
            'name' => $name,
            'industry' => $industry,
            'city' => $city,
            'website' => $website,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->pdo()->lastInsertId();
    }

    public function update(
        int $id,
        string $name,
        string $industry,
        string $city,
        ?string $website,
        string $description,
    ): void {
        $statement = $this->pdo()->prepare(
            'UPDATE companies
             SET name = :name,
                 industry = :industry,
                 city = :city,
                 website = :website,
                 description = :description
             WHERE id = :id'
        );
        $statement->execute([
            'id' => $id,
            'name' => $name,
            'industry' => $industry,
            'city' => $city,
            'website' => $website,
            'description' => $description,
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo()->prepare('DELETE FROM companies WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function countOffers(int $companyId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM offers
             WHERE company_id = :company_id'
        );
        $statement->execute(['company_id' => $companyId]);

        return (int) $statement->fetchColumn();
    }

    public function all(): array
    {
        $statement = $this->pdo()->query(
            'SELECT id, name
             FROM companies
             ORDER BY name ASC'
        );

        return $statement->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->pdo()->query(
            'SELECT COUNT(*)
             FROM companies'
        )->fetchColumn();
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }
}
