<?php

namespace lms\feature\signup;

enum SignUpResult
{
    case Success;
    case UsernameTaken;
}
