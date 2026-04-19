<?php

namespace lms\feature\login;

enum LoginResult
{
    case DriverLoginSuccess;
    case MaintainerLoginSuccess;
    case CentralOfficeLoginSuccess;
    case UsernameOrPasswordIncorrect;
    case UserNotFound;
}
