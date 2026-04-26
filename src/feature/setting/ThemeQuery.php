<?php

namespace lms\feature\setting;

use Exception;
use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\signup\entities\IUserRepository;
use lms\feature\setting\entities\UserPreference;
use lms\feature\setting\exception\UserNotFoundException;

class ThemeQuery
{
    public IUserPreferenceRepository $preferences;
    public IUserRepository $users;

    public function __construct(IUserPreferenceRepository $preferences, IUserRepository $users)
    {
        $this->preferences = $preferences;
        $this->users = $users;
    }

    private function get_preference(int $user_id): UserPreference|null
    {
        $user = $this->users->get($user_id);

        if (!$user) throw new UserNotFoundException();

        $filtered =
            array_values(
                array_filter(
                    $this->preferences->getAll(),
                    function (UserPreference $preference) use ($user_id) {
                        return $preference->user_id == $user_id;
                    }
                )
            );

        return array_shift($filtered);
    }

    public function get_current_theme(int $user_id)
    {
        $preference = $this->get_preference($user_id);

        if (!$preference) {
            $this->preferences->insert(
                new UserPreference($this->preferences->count() + 1, $user_id, ThemeVariant::Light, LanguageVariant::Indonesia)
            );

            $preference = $this->get_preference($user_id);
        }


        return $preference->theme;
    }
}
