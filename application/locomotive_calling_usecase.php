<?php
class LocomotiveCallingUsecase
{
	public readonly ILocomotiveRepository $locomotive;
	public readonly ILocomotiveCallQueue $call_queue;

	public function call_locomotive(string $locomotive_id)
	{
		$target_loco = $this->locomotive->get_by_id($locomotive_id);
		$this->call_queue->call($target_loco);
	}
}
