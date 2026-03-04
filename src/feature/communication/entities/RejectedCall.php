<?php

namespace lms\feature\communication\entities;

class RejectedCall
{
    public int $id;
    public int $call_id;
    public string $reason;

    public function __construct(int $id, int $call_id, string $reason)
    {
        $this->id = $id;
        $this->call_id = $call_id;
        $this->reason = $reason;
    }
}