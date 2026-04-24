<?php

namespace lms\feature\setting\persistence;

use Error;
use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\entities\IDriverPreferenceRepository;

class InMemoryDriverPreferenceRepository implements IDriverPreferenceRepository
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

    public function insert(int $id, int $driver_id, string $theme, string $language): void
    {
        $this->user_preferences[$id - 1] = new DriverPreference($id, $driver_id, $theme, $language);
    }

    public function get(int $id): DriverPreference
    {
        return $this->user_preferences[$id - 1] ?? null;
    }


    public function getAll(): array
    {
        return array_values($this->user_preferences);
    }

    public function update(int $id, int $driver_id, string $theme, string $language): void
    {
        if (isset($this->user_preferences[$id - 1])) {
            $this->user_preferences[$id - 1]->user_id = $driver_id;
            $this->user_preferences[$id - 1]->theme = $theme;
            $this->user_preferences[$id - 1]->language = $language;
        } else {
            throw new Error("cannot find user with the id of $id");
        }
    }

    public function delete(int $id): void
    {
        unset($this->user_preferences[$id - 1]);
    }
}
