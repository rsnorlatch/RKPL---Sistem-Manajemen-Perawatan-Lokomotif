<?php

namespace lms\feature\communication\entities;

class AcceptedCall
{
    public int $id;
    public int $call_id;

    public function __construct(int $id, int $call_id)
    {
        $this->id = $id;
        $this->call_id = $call_id;
    }
}
