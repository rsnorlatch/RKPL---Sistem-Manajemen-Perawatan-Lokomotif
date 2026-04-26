<?php

namespace lms\feature\setting;

use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\setting\entities\UserPreference;
use lms\feature\signup\entities\IUserRepository;

use Exception;

class GetCurrentLanguageHandler
{
    private IUserRepository $users;
    private IUserPreferenceRepository $preferences;

    public function __construct(IUserRepository $users, IUserPreferenceRepository $preferences)
    {
        $this->users = $users;
        $this->preferences = $preferences;
    }

    public function handle(int $user_id)
    {
        $filtered =
            array_values(
                array_filter(
                    $this->preferences->getAll(),
                    function (UserPreference $p) use ($user_id) {
                        return $p->user_id == $user_id;
                    }
                )
            );
        $all_preference = array_shift($filtered);

        // Kalau user belum punya preference, kembalikan default Indonesia
        if (!$all_preference)
            return LanguageVariant::Indonesia;

        return $all_preference->language;
    }
}