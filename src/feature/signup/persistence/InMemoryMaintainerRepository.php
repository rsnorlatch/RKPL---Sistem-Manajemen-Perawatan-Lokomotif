<?php

namespace lms\feature\signup\persistence;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\signup\entities\IMaintainerRepository;
use lms\feature\signup\entities\Maintainer;
use Error;

class InMemoryMaintainerRepository implements IMaintainerRepository
{
    private array $maintainer = [];

    public function __construct(array $maintainer = [])
    {
        $this->maintainer = $maintainer;
    }

    public function count(): int
    {
        return count($this->maintainer);
    }

    public function insert(int $id, string $username, string $email, string $password): void
    {
        array_push($this->maintainer, new Maintainer($id, $username, $email, $password));
    }

    public function get(int $id)
    {
        return $this->maintainer[$id - 1] ?? null;
    }

    public function getByUsername(string $username)
    {
        foreach ($this->maintainer as $maintainer) {
            if ($maintainer->name === $username) {
                return $maintainer;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return array_values($this->maintainer);
    }

    public function update(int $id, string $username, string $email, string $password): void
    {
        if (isset($this->maintainer[$id - 1])) {
            $this->maintainer[$id - 1]->name = $username;
            $this->maintainer[$id - 1]->email = $email;
            $this->maintainer[$id - 1]->password = $password;
        } else {
            throw new Error("cannot find user with the id of $id");
        }
    }

    public function delete(int $id): void
    {
        unset($this->maintainer[$id]);
    }
}
