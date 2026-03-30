<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class UserRepository
{
    public function emailExists(string $email, ?int $exceptId = null): bool
    {
        $query = 'SELECT COUNT(*) FROM users WHERE email = :email';
        $bindings = ['email' => mb_strtolower($email)];

        if ($exceptId !== null) {
            $query .= ' AND id != :except_id';
            $bindings['except_id'] = $exceptId;
        }

        $statement = $this->pdo()->prepare($query);
        $statement->execute($bindings);

        return (int) $statement->fetchColumn() > 0;
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT id, first_name, last_name, email, password_hash, role, promotion_id
             FROM users
             WHERE email = :email
             LIMIT 1'
        );
        $statement->execute(['email' => mb_strtolower($email)]);
        $user = $statement->fetch();

        return is_array($user) ? $user : null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT id, first_name, last_name, email, role, promotion_id
             FROM users
             WHERE id = :id
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $user = $statement->fetch();

        return is_array($user) ? $user : null;
    }

    public function findByIdWithPromotion(int $id): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT users.id, users.first_name, users.last_name, users.email, users.role, users.promotion_id,
                    promotions.name AS promotion_name
             FROM users
             LEFT JOIN promotions ON promotions.id = users.promotion_id
             WHERE users.id = :id
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $user = $statement->fetch();

        return is_array($user) ? $user : null;
    }

    public function listAccounts(): array
    {
        $statement = $this->pdo()->query(
            'SELECT id, first_name, last_name, email, role, promotion_id
             FROM users
             ORDER BY role ASC, last_name ASC, first_name ASC'
        );

        return $statement->fetchAll();
    }

    public function listManageableAccounts(): array
    {
        $statement = $this->pdo()->query(
            "SELECT id, first_name, last_name, email, role, promotion_id
             FROM users
             WHERE role IN ('pilote', 'etudiant')
             ORDER BY role ASC, last_name ASC, first_name ASC"
        );

        return $statement->fetchAll();
    }

    public function listStudentsByPromotion(int $promotionId): array
    {
        $statement = $this->pdo()->prepare(
            'SELECT id, first_name, last_name, email, promotion_id
             FROM users
             WHERE role = :role AND promotion_id = :promotion_id
             ORDER BY last_name ASC, first_name ASC'
        );
        $statement->execute([
            'role' => 'etudiant',
            'promotion_id' => $promotionId,
        ]);

        return $statement->fetchAll();
    }

    public function countByRole(string $role): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM users
             WHERE role = :role'
        );
        $statement->execute(['role' => $role]);

        return (int) $statement->fetchColumn();
    }

    public function createStudent(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        int $promotionId,
    ): int {
        return $this->createAccount($firstName, $lastName, $email, $password, 'etudiant', $promotionId);
    }

    public function createPilot(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        int $promotionId,
    ): int {
        return $this->createAccount($firstName, $lastName, $email, $password, 'pilote', $promotionId);
    }

    public function updateAccount(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
        string $role,
        ?int $promotionId,
        ?string $password = null,
    ): void {
        $fields = [
            'first_name = :first_name',
            'last_name = :last_name',
            'email = :email',
            'role = :role',
            'promotion_id = :promotion_id',
        ];
        $bindings = [
            'id' => $id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => mb_strtolower($email),
            'role' => $role,
            'promotion_id' => $promotionId,
        ];

        if ($password !== null && $password !== '') {
            $fields[] = 'password_hash = :password_hash';
            $bindings['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $statement = $this->pdo()->prepare(
            'UPDATE users
             SET ' . implode(', ', $fields) . '
             WHERE id = :id'
        );
        $statement->execute($bindings);
    }

    public function deleteAccount(int $id): void
    {
        $user = $this->findById($id);

        if (! is_array($user)) {
            return;
        }

        $this->pdo()->beginTransaction();

        try {
            if (($user['role'] ?? null) === 'etudiant') {
                $applications = $this->pdo()->prepare('DELETE FROM applications WHERE student_id = :student_id');
                $applications->execute(['student_id' => $id]);
            }

            $statement = $this->pdo()->prepare('DELETE FROM users WHERE id = :id');
            $statement->execute(['id' => $id]);
            $this->pdo()->commit();
        } catch (\Throwable $exception) {
            $this->pdo()->rollBack();
            throw $exception;
        }
    }

    private function pdo(): PDO
    {
        return Database::connection();
    }

    private function createAccount(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $role,
        ?int $promotionId,
    ): int {
        $statement = $this->pdo()->prepare(
            'INSERT INTO users (first_name, last_name, email, password_hash, role, promotion_id, created_at)
             VALUES (:first_name, :last_name, :email, :password_hash, :role, :promotion_id, :created_at)'
        );
        $statement->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => mb_strtolower($email),
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'promotion_id' => $promotionId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->pdo()->lastInsertId();
    }
}
