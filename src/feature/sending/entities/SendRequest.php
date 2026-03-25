<?php

namespace lms\feature\sending\entities;

use DateTime;

class SendRequest
{
    public int $id;
    public int $locomotive_id;
    public Stop $destination;
    public DateTime $request_time;
}
