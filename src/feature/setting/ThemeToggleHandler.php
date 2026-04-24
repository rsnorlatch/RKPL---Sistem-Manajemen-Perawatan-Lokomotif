<?php

namespace lms\feature\setting;

use lms\feature\setting\persistence\InMemoryUserPreferenceRepository;
use lms\feature\signup\entities\IUserRepository;
use Error;
use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\setting\entities\UserPreference;

class ThemeToggleHandler
{
    public IUserPreferenceRepository $preferences;
    public IUserRepository $users;

    public function __construct(IUserPreferenceRepository $preferences, IUserRepository $users)
    {
        $this->preferences = $preferences;
        $this->users = $users;
    }

    public function handle(int $user_id)
    {
        $preference =
            array_shift(
                array_values(
                    array_filter(
                        $this->preferences->getAll(),
                        function (UserPreference $preference) use ($user_id) {
                            return $preference->user_id == $user_id;
                        }
                    )
                )
            );

        if (!$preference)
            throw new Error("preference doesn't exists!");

        $preference->theme = $preference->theme == ThemeVariant::Light ? ThemeVariant::Dark : ThemeVariant::Light;

        $this->preferences->update($preference);
    }
}
