<?php

namespace lms\feature\locomotive_management\entities;

class OnSiteLocomotive
{
    public int $id;
    public int $locomotive_id;

    public function __construct(int $id, int $locomotive_id)
    {
        $this->id = $id;
        $this->locomotive_id = $locomotive_id;
    }
}
