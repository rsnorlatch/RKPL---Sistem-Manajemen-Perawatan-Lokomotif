<?php

namespace lms\feature\setting\persistence;

use Error;
use lms\feature\setting\entities\UserPreference;
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

    public function insert(UserPreference $preference): void
    {
        $this->user_preferences[$preference->id - 1] =
            new UserPreference($preference->id, $preference->user_id, $preference->theme, $preference->language);
    }

    public function get(int $id): UserPreference
    {
        return $this->user_preferences[$id - 1] ?? null;
    }


    public function getAll(): array
    {
        return array_values($this->user_preferences);
    }

    public function update(UserPreference $preference): void
    {
        if (isset($this->user_preferences[$preference->id - 1])) {
            $this->user_preferences[$preference->id - 1]->user_id = $preference->user_id;
            $this->user_preferences[$preference->id - 1]->theme = $preference->theme;
            $this->user_preferences[$preference->id - 1]->language = $preference->language;
        } else {
            throw new Error("cannot find user with the id of $preference->id");
        }
    }

    public function delete(int $id): void
    {
        unset($this->user_preferences[$id - 1]);
    }
}
