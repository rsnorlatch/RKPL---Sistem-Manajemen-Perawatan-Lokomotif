<?php
include "./user.php";

class BalaiYasaUser implements User
{
	public $user_id;
	public readonly string $username;
	public readonly string $email;
	public readonly string $password;
}
