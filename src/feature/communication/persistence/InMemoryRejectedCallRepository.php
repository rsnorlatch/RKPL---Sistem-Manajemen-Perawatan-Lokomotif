<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\IRejectedCallRepository;
use lms\feature\communication\entities\RejectedCall;
use DateTime;

require_once __DIR__ . "../../../../../vendor/autoload.php";

class InMemoryRejectedCallRepository implements IRejectedCallRepository
{
    private array $rejectedCalls = [];

    public function __construct(array $rejectedCalls = [])
    {
        $this->rejectedCalls = $rejectedCalls;
    }

    public function count(): int
    {
        return count($this->rejectedCalls);
    }

    public function insert(int $id, int $call_id, string $reason): void
    {
        $this->rejectedCalls[$id] = new RejectedCall($id, $call_id, $reason);
    }

    public function get(int $id): RejectedCall | null
    {
        return $this->rejectedCalls[$id] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->rejectedCalls);
    }

    public function update(int $id, int $call_id, string $reason): void
    {
        if (isset($this->rejectedCalls[$id])) {
            $this->rejectedCalls[$id]->call_id = $call_id;
            $this->rejectedCalls[$id]->reason = $reason;
        }
    }

    public function delete(int $id): void
    {
        unset($this->rejectedCalls[$id]);
    }
}
