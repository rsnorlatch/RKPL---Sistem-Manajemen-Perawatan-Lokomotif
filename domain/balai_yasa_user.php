<?php

namespace main\domain;

class BalaiYasaUser implements User
{
	public $user_id;
	public readonly string $username;
	public readonly string $email;
	public readonly string $password;

	function __construct(string $id, string $username, string $email, string $password)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}
}
