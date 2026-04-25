<?php

namespace lms\feature\setting;

use lms\feature\signup\entities\IUserRepository;
use Error;
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

    private function get_preference(int $user_id)
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

    public function switch_to_dark_mode(int $user_id)
    {
        $preference = $this->get_preference($user_id);

        if (!$preference)
            throw new Error("preference doesn't exists!");

        $preference->theme = ThemeVariant::Dark;

        $this->preferences->update($preference);
    }

    public function switch_to_light_mode(int $user_id)
    {
        $preference = $this->get_preference($user_id);

        if (!$preference)
            throw new Error("preference doesn't exists!");

        $preference->theme = ThemeVariant::Light;

        $this->preferences->update($preference);
    }
}
