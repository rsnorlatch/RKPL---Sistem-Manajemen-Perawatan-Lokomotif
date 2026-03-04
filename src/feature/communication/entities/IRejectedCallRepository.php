<?php

namespace lms\feature\communication\entities;

use DateTime;
use lms\feature\communication\entities\RejectedCall;

interface IRejectedCallRepository
{
    public function count(): int;

    public function insert(int $id, int $call_id, string $reason): void;

    public function get(int $id): RejectedCall | null;

    public function getAll(): array;

    public function update(int $id, int $call_id, string $reason): void;

    public function delete(int $id): void;
}
