<?php

namespace lms\feature\sending\entities;

use DateTime;

class SendRequest
{
	public int $id;
	public int $locomotive_id;
	public int $destination_id;
	public DateTime $request_time;

	function __construct(int $id, int $locomotive_id, int $destination_id, DateTime $request_time)
	{
		$this->id = $id;
		$this->locomotive_id = $locomotive_id;
		$this->destination_id = $destination_id;
		$this->request_time = $request_time;
	}
}
