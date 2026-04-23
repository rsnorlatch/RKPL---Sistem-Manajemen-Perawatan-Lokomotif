<?php

namespace lms\feature\setting;


enum ChangeUsernameResult
{
    case UsernameNotFound;
    case Success;
}
