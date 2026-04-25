<?php

namespace lms\feature\setting;

use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\signup\entities\IUserRepository;
use lms\feature\setting\entities\UserPreference;

class ThemeQuery
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
        return array_shift(
            array_values(
                array_filter(
                    $this->preferences->getAll(),
                    function (UserPreference $preference) use ($user_id) {
                        return $preference->user_id == $user_id;
                    }
                )
            )
        );
    }

    public function get_current_theme(int $user_id)
    {
        $preference = $this->get_preference($user_id);
        return $preference->theme;
    }
}
