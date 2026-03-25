<?php

namespace lms\feature\sending\entities;

use DateTime;
use lms\feature\locomotive_management\entities\Locomotive;

interface ISendRequestRepository
{
	public function count(): int;

	public function insert(int $id, int $locomotive_id, int $destination_id, DateTime $request_time): void;

	public function get(int $id): SendRequest;

	public function getAll(): array;

	public function update(int $id, int $locomotive_id, int $destination_id, DateTime $request_time): void;

	public function delete(int $id): void;
}
