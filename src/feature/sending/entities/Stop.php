<?php

namespace lms\feature\sending\entities;

class Stop
{
	public int $id;
	public string $name;
	public float $x;
	public float $y;

	function __construct(int $id, string $name, float $x, float $y)
	{
		$this->id = $id;
		$this->name = $name;
		$this->x = $x;
		$this->y = $y;
	}
}
