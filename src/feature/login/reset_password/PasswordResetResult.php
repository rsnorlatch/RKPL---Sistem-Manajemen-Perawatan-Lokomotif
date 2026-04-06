<?php

namespace lms\feature\login\reset_password;

enum PasswordResetResult
{
    case Success;
    case UsernameNotFound;
}
