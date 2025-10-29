<?php
include "../domain/locomotive.php";
class InMemoryLocomotiveRepository implements ILocomotiveRepository
{
	public readonly array $db; // array of locomotive

	function __construct(array $db)
	{
		$this->db = $db;
	}

	function get_by_id(string $locomotive_id)
	{
		return $this->db[$locomotive_id];
	}
}
