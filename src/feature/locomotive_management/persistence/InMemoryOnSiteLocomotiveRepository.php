<?php

namespace lms\feature\locomotive_management\persistence;

use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;

class InMemoryOnSiteLocomotiveRepository implements IOnSiteLocomotiveRepository
{
    private const SESSION_KEY = 'on_site_locomotives';

    public function __construct(array $locomotives = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = $locomotives;
        }
    }

    public function count(): int
    {
        return count($_SESSION[self::SESSION_KEY] ?? []);
    }

    public function insert(int $id, int $driver_id, string $model): void
    {
        $_SESSION[self::SESSION_KEY][$id] = new Locomotive($id, $driver_id, $model);
    }

    public function get(int $id)
    {
        return $_SESSION[self::SESSION_KEY][$id] ?? null;
    }

    public function getAll(): array
    {
        return array_values($_SESSION[self::SESSION_KEY] ?? []);
    }

    public function update(int $id, int $driver_id, string $model): void
    {
        if (isset($_SESSION[self::SESSION_KEY][$id])) {
            $_SESSION[self::SESSION_KEY][$id]->driver_id = $driver_id;
            $_SESSION[self::SESSION_KEY][$id]->model = $model;
        }
    }

    public function delete(int $id): void
    {
        unset($_SESSION[self::SESSION_KEY][$id]);
    }
}
