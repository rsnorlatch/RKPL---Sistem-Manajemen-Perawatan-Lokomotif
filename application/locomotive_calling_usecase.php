<?php
include "../persistent/inmemory_locomotive_call_queue.php";
include "../persistent/inmemory_locomotive_repository.php";

class LocomotiveCallingUsecase
{
	public readonly ILocomotiveRepository $locomotive;
	public readonly ILocomotiveCallQueue $call_queue;

	private function __construct(ILocomotiveRepository $locomotive, ILocomotiveCallQueue $call_queue)
	{
		$this->locomotive = $locomotive;
		$this->call_queue = $call_queue;
	}

	public static function create_mocked(array $mock_db, array $mock_queue)
	{
		return new LocomotiveCallingUsecase(
			new InMemoryLocomotiveRepository($mock_db),
			new InMemoryLocomotiveCallQueue($mock_queue)
		);
	}

	public function call_locomotive(string $locomotive_id)
	{
		$target_loco = $this->locomotive->get_by_id($locomotive_id);
		$this->call_queue->call($target_loco);
	}
}
