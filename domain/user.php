<?php

namespace main\domain;

abstract class User
{
  public $user_id;
  public readonly string $username;
  public readonly string $email;
  public readonly string $password;
}
