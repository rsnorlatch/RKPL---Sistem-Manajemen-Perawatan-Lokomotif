<?php

namespace lms\feature\setting\entities;

use lms\feature\setting\ThemeVariant;

interface IUserPreferenceRepository
{
    public function count(): int;

    public function insert(int $id, int $user_id, ThemeVariant $theme): void;

    public function get(int $id);

    public function getAll(): array;

    public function update(int $id, int $user_id, ThemeVariant $theme): void;

    public function delete(int $id): void;
}
