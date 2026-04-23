<?php

namespace lms\feature\setting\persistence;

use Error;
use lms\feature\setting\entities\UserPreference;
use lms\feature\setting\ThemeVariant;
use lms\feature\setting\entities\IUserPreferenceRepository;

class InMemoryUserPreferenceRepository implements IUserPreferenceRepository
{
    private array $user_preferences = [];

    public function __construct(array $user_preferences = [])
    {
        $this->user_preferences = $user_preferences;
    }

    public function count(): int
    {
        return count($this->user_preferences);
    }

    public function insert(int $id, int $user_id, ThemeVariant $theme): void
    {
        $this->user_preferences[$id - 1] = new UserPreference($id, $user_id, $theme);
    }

    public function get(int $id): UserPreference
    {
        return $this->user_preferences[$id - 1] ?? null;
    }


    public function getAll(): array
    {
        return array_values($this->user_preferences);
    }

    public function update(int $id, int $user_id, ThemeVariant $theme): void
    {
        if (isset($this->user_preferences[$id - 1])) {
            $this->user_preferences[$id - 1]->user_id = $user_id;
            $this->user_preferences[$id - 1]->theme = $theme;
        } else {
            throw new Error("cannot find user with the id of $id");
        }
    }

    public function delete(int $id): void
    {
        unset($this->user_preferences[$id - 1]);
    }
}
