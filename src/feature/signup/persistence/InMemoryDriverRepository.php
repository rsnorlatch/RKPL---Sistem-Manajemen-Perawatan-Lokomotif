<?php
namespace lms\feature\signup\persistence;

require_once __DIR__."../../../../../vendor/autoload.php";

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
        $this->drivers[$id] = new Driver($id, $username, $email, $password);
    }

    public function get(int $id)
    {
        return $this->drivers[$id] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->drivers);
    }

    public function update(int $id, string $username, string $email, string $password): void
    {
        if (isset($this->drivers[$id])) {
            $this->drivers[$id]->name = $username;
            $this->drivers[$id]->email = $email;
            $this->drivers[$id]->password = $password;
        }
    }

    public function delete(int $id): void
    {
        unset($this->drivers[$id]);
    }
}
