<?php

namespace lms\feature\setting;

use lms\feature\signup\entities\IUserRepository;
use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\setting\entities\UserPreference;

class ThemeDispatcher
{
    public IUserPreferenceRepository $preferences;
    public IUserRepository $users;

    public function __construct(IUserPreferenceRepository $preferences, IUserRepository $users)
    {
        $this->preferences = $preferences;
        $this->users = $users;
    }

    private function get_preference(int $user_id): UserPreference
    {
        $filtered = array_values(
            array_filter(
                $this->preferences->getAll(),
                function (UserPreference $preference) use ($user_id) {
                    return $preference->user_id == $user_id;
                }
            )
        );

        $existing = array_shift($filtered);

        // FIX: kalau user belum punya preference, auto-create dengan default
        if (!$existing) {
            $new_id = $this->preferences->count() + 1;
            $existing = new UserPreference(
                $new_id,
                $user_id,
                ThemeVariant::Light,
                LanguageVariant::Indonesia
            );
            $this->preferences->insert($existing);
        }

        return $existing;
    }

    public function switch_to_dark_mode(int $user_id)
    {
        $preference = $this->get_preference($user_id);
        $preference->theme = ThemeVariant::Dark;
        $this->preferences->update($preference);
    }

    public function switch_to_light_mode(int $user_id)
    {
        $preference = $this->get_preference($user_id);
        $preference->theme = ThemeVariant::Light;
        $this->preferences->update($preference);
    }
}