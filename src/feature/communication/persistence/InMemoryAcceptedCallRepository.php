<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\IAcceptedCallRepository;
use lms\feature\communication\entities\AcceptedCall;

require_once __DIR__ . "../../../../../vendor/autoload.php";

class InMemoryAcceptedCallRepository implements IAcceptedCallRepository
{
    private array $acceptedCalls;

    public function __construct(array $acceptedCalls)
    {
        $this->acceptedCalls = $acceptedCalls;
    }

    public function count(): int
    {
        return count($this->acceptedCalls);
    }

    public function insert(int $id, int $call_id): void
    {
        $this->acceptedCalls[$id - 1] = new AcceptedCall($id, $call_id);
    }

    public function get(int $id): AcceptedCall | null
    {
        return $this->acceptedCalls[$id - 1] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->acceptedCalls);
    }

    public function update(int $id, int $call_id): void
    {
        if (isset($this->acceptedCalls[$id - 1])) {
            $this->acceptedCalls[$id - 1]->call_id = $call_id;
        }
    }

    public function delete(int $id): void
    {
        unset($this->acceptedCalls[$id - 1]);
    }
}
