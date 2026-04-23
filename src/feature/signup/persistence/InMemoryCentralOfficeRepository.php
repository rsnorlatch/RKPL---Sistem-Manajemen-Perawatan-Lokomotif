<?php

namespace lms\feature\signup\persistence;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\signup\entities\ICentralOfficeRepository;
use lms\feature\signup\entities\CentralOffice;
use Error;

class InMemoryCentralOfficeRepository implements ICentralOfficeRepository
{
    private array $central_office = [];

    public function __construct(array $central_office = [])
    {
        $this->central_office = $central_office;
    }

    public function count(): int
    {
        return count($this->central_office);
    }

    public function insert(int $id, string $username, string $email, string $password): void
    {

        array_push($this->central_office, new CentralOffice($id, $username, $email, $password));
    }

    public function get(int $id)
    {
        return $this->central_office[$id - 1] ?? null;
    }

    public function getByUsername(string $username)
    {
        foreach ($this->central_office as $central_office) {
            if ($central_office->name === $username) {
                return $central_office;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return array_values($this->central_office);
    }

    public function update(int $id, string $username, string $email, string $password): void
    {
        if (!isset($this->central_office[$id - 1])) {
            throw new Error("cannot find user with the id of $id");
        }

        $this->central_office[$id - 1]->name = $username;
        $this->central_office[$id - 1]->email = $email;
        $this->central_office[$id - 1]->password = $password;
    }

    public function delete(int $id): void
    {
        unset($this->central_office[$id - 1]);
    }
}
