<?php

namespace lms\feature\setting;

use lms\feature\signup\entities\IUserRepository;

class ChangePasswordHandler
{
    public IUserRepository $users;

    public function __construct(IUserRepository $users)
    {
        $this->users = $users;
    }

    public function handle(int $user_id, string $old, string $new, string $confirm_new)
    {
        $user = $this->users->get($user_id);

        if (!$user)
            return ChangePasswordResult::UserNotFound;

        if ($user->password != $old)
            return ChangePasswordResult::OldPasswordIncorrect;

        if ($new != $confirm_new)
            return ChangePasswordResult::ConfirmPasswordNotMatch;


        $this->users->update($user->id, $user->name, $user->email, $new);

        return ChangePasswordResult::Success;
    }
}
