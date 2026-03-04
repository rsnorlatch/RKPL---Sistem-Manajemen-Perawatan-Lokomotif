<?php

namespace lms\feature\communication\entities;

interface IAcceptedCallRepository
{
    public function count(): int;

    public function insert(int $id, int $call_id): void;

    public function get(int $id): AcceptedCall | null;

    public function getAll(): array;

    public function update(int $id, int $call_id): void;

    public function delete(int $id): void;
}
