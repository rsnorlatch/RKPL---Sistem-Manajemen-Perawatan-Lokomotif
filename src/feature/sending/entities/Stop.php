<?php

namespace lms\feature\sending\entities;

class Stop
{
	public int $id;
	public string $name;
	public $x;
	public $y;

	function __construct(int $id, string $name, int $x, int $y)
	{
		$this->id = $id;
		$this->name = $name;
		$this->x = $x;
		$this->y = $y;
	}
}
