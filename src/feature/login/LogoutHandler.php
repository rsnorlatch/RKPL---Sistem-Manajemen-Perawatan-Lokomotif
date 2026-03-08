<?php

namespace lms\feature\login;

class LogoutHandler
{
    function handle()
    {
        session_start();
        session_destroy();
        header("Location: ../../../../front-end/login.php");
    }
}
