<?php

namespace lms\feature\locomotive_management\entities;

interface IOnSiteLocomotiveRepository
{
    public function count(): int;

    public function insert(int $onsite_locomotive_id, int $locomotive_id): void;

    public function get(int $id);

    public function getAll(): array;

    public function update(int $onsite_locomotive_id, int $locomotive_id): void;

    public function delete(int $id): void;
}
