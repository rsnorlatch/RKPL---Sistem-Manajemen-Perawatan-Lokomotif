<?php
class InMemoryLocomotiveCallQueue implements ILocomotiveCallQueue
{
  public readonly array $queue;

  function __construct(array $queue)
  {
    $this->queue = $queue;
  }

  function call(string $locomotive_id)
  {
    array_push($this->queue, $locomotive_id);
  }
}
