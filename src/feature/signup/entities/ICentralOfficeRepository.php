<?php

namespace lms\feature\signup\entities;

interface ICentralOfficeRepository
{
    public function count(): int;

    public function insert(int $id, string $username, string $email, string $password): void;

    public function get(int $id);
    
    public function getByUsername(string $username);

    public function getAll(): array;

    public function update(int $id, string $username, string $email, string $password): void;

    public function delete(int $id): void;
}
