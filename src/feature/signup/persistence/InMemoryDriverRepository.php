<?php

namespace lms\feature\signup\persistence;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use Error;
use lms\feature\signup\entities\IDriverRepository;
use lms\feature\signup\entities\Driver;

class InMemoryDriverRepository implements IDriverRepository
{
    private array $drivers = [];

    public function __construct(array $drivers = [])
    {
        $this->drivers = $drivers;
    }

    public function count(): int
    {
        return count($this->drivers);
    }

    public function insert(int $id, string $username, string $email, string $password): void
    {
        $this->drivers[$id - 1] = new Driver($id, $username, $email, $password);
    }

    public function get(int $id)
    {
        return $this->drivers[$id - 1] ?? null;
    }

    public function getByUsername(string $username)
    {
        foreach ($this->drivers as $driver) {
            if ($driver->name === $username) {
                return $driver;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return array_values($this->drivers);
    }

    // TODO: replace every update function in every repository with the new implementation below
    public function update(int $id, string $username, string $email, string $password): void
    {
        if (isset($this->drivers[$id - 1])) {
            $this->drivers[$id - 1]->name = $username;
            $this->drivers[$id - 1]->email = $email;
            $this->drivers[$id - 1]->password = $password;
        } else {
            throw new Error("cannot find user with the id of $id");
        }
    }

    public function delete(int $id): void
    {
        unset($this->drivers[$id]);
    }
}
