<?php

namespace lms\feature\setting;

enum ChangePasswordResult
{
    case ConfirmPasswordNotMatch;
    case UserNotFound;
    case Success;
    case OldPasswordIncorrect;
}
