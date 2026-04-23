<?php

namespace lms\feature\setting;

use lms\feature\signup\entities\IUserRepository;

class ChangeUsernameHandler
{
    public IUserRepository $users;

    public function __construct(IUserRepository $users)
    {
        $this->users = $users;
    }

    public function handle(string $old, string $new)
    {
        $user = $this->users->getByUsername($old);

        if (!$user) {
            return ChangeUsernameResult::UsernameNotFound;
        }

        $this->users->update($user->id, $new, $user->email, $user->password);
        session_start();
        $_SESSION['user'] = $new;

        return ChangeUsernameResult::Success;
    }
}
