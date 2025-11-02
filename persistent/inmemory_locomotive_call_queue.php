<?php

namespace main\persistence;

class InMemoryLocomotiveCallQueue implements ILocomotiveCallQueue
{
  private array $queue;

  function __construct(array $queue)
  {
    $this->queue = $queue;
  }

  function call(string $locomotive_id)
  {
    array_push($this->queue, $locomotive_id);
  }

  function get_queue(): array
  {
    return $this->queue;
  }
}
