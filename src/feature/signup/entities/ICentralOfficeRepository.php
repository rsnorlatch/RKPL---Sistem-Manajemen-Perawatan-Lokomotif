<?php

namespace lms\feature\signup\entities;

interface ICentralOfficeRepository
{
    /**
     * Get total count of drivers
     */
    public function count(): int;

    /**
     * Insert a new driver
     */
    public function insert(int $id, string $username, string $email, string $password): void;

    /**
     * Get a driver by ID
     */
    public function get(int $id);

    /**
     * Get all drivers
     */
    public function getAll(): array;

    /**
     * Update a driver
     */
    public function update(int $id, string $username, string $email, string $password): void;

    /**
     * Delete a driver by ID
     */
    public function delete(int $id): void;
}
