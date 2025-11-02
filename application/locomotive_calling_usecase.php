<?php

namespace main\application;

use main\domain\ILocomotiveRepository;
use main\persistence\ILocomotiveCallQueue;

use main\persistence\InMemoryLocomotiveCallQueue;
use main\persistence\InMemoryLocomotiveRepository;

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

  public function execute(string $locomotive_id)
  {
    $target_loco = $this->locomotive->get_by_id($locomotive_id);
    if (is_null($target_loco)) return;

    $this->call_queue->call($locomotive_id);
  }
}
