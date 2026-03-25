<?php

namespace lms\feature\sending\entities;

interface IStopRepository
{
	public function count(): int;

	public function insert(int $id, string $name, int $x, int $y): void;

	public function get(int $id): Stop;

	public function getAll(): array;

	public function update(int $id, string $name, int $x, int $y): void;

	public function delete(int $id): void;
}
