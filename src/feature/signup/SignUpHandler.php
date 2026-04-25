<?php

namespace lms\feature\signup;

use lms\feature\setting\entities\CentralOfficePreference;
use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\setting\entities\MaintainerPreference;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\ThemeVariant;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\IUserRepository;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\entities\User;

class SignUpHandler
{
    public IUserRepository $_users;
    public IUserPreferenceRepository $_preferences;

    public function __construct(IUserRepository $users, IUserPreferenceRepository $preferences)
    {
        $this->_users = $users;
        $this->_preferences = $preferences;
    }

    public function handle($username, $email, $password)
    {
        $new_id = $this->_users->count() + 1;

        $is_taken = count(array_filter($this->_users->getAll(), function (User $d) use ($username, $email) {
            return $d->name == $username || $d->email == $email;
        })) > 0;

        if ($is_taken)
            return SignUpResult::UsernameTaken;


        $this->_users->insert($new_id, $username, $email, $password);

        $user_type = $this->_users->get($new_id);
        $preference = $user_type::class == Driver::class ?
            new DriverPreference(1, $new_id, ThemeVariant::Light, LanguageVariant::Indonesia)
            : ($user_type::class == Maintainer::class ? new MaintainerPreference(1, $new_id, ThemeVariant::Light, LanguageVariant::Indonesia)
                : new CentralOfficePreference(1, $new_id, ThemeVariant::Light, LanguageVariant::Indonesia));

        $this->_preferences->insert($preference);
    }
}
