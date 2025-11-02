<?php

namespace main\persistence;

use main\domain\ILocomotiveRepository;

class InMemoryLocomotiveRepository implements ILocomotiveRepository
{
	public readonly array $db; // array of locomotive

	public function __construct(array $db)
	{
		$this->db = $db;
	}

	public function get_by_id(string $locomotive_id)
	{
		return $this->db[$locomotive_id];
	}
}
