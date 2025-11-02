<?php

namespace main\domain;

class Locomotive
{
  public string $id;

  function __construct(string $id)
  {
    $this->id = $id;
  }
}
