<?php

namespace lms\feature\setting;

use Error;
use lms\feature\setting\entities\CentralOfficePreference;
use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\setting\entities\MaintainerPreference;
use lms\feature\setting\entities\UserPreference;
use lms\feature\signup\entities\IUserRepository;

class ChangeLanguagehandler
{
    private IUserPreferenceRepository $preferences;
    private IUserRepository $users;

    public function __construct(IUserPreferenceRepository $preferences, IUserRepository $users)
    {
        $this->preferences = $preferences;
        $this->users = $users;
    }

    public function handle(int $user_id, LanguageVariant $language)
    {
        $user = $this->users->get($user_id);

        if (!$user)
            throw new Error("user not found");

        $unshifted_preference =
            array_values(
                array_filter(
                    $this->preferences->getAll(),
                    function (UserPreference $p) use ($user_id) {
                        return $p->user_id == $user_id;
                    }
                )
            );
        $preference = array_shift($unshifted_preference);

        $driver_preference = new DriverPreference($preference->id, $preference->user_id, $preference->theme, $language);
        $maintianer_preference = new MaintainerPreference($preference->id, $preference->user_id, $preference->theme, $language);
        $central_office_preference = new CentralOfficePreference($preference->id, $preference->user_id, $preference->theme, $language);

        $this->preferences->update(
            $preference::class == DriverPreference::class ? $driver_preference
                : ($preference::class == MaintainerPreference::class ? $maintianer_preference
                    : $central_office_preference)
        );
    }
}
