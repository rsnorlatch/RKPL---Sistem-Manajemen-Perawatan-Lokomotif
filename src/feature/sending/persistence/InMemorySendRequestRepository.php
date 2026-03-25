<?php

namespace lms\feature\sending\persistence;

use lms\feature\sending\entities\ISendRequestRepository;
use lms\feature\sending\entities\SendRequest;

class InMemorySendRequestRepository implements ISendRequestRepository
{
    private array $_send_requests;

    function __construct(array $_send_requests)
    {
        $this->_send_requests = $_send_requests;
    }

    public function count(): int
    {
        return count($this->_send_requests);
    }

    public function insert(): void
    {
        array_push($this->_send_requests, new SendRequest());
    }

    public function get(int $id): SendRequest
    {
        return array_filter($this->_send_requests, function (SendRequest $s) use ($id) {
            return $s->id == $id;
        })[0];
    }

    public function getAll(): array
    {
        return $this->_send_requests;
    }

    public function update(int $id, string $name, int $x, int $y): void
    {
        foreach ($this->_send_requests as $s) {
            if ($s->id == $id) {
                $s->name = $name;
                $s->x = $x;
                $s->y = $y;
            }
        }
    }

    public function delete(int $id): void
    {
        foreach ($this->_send_requests as $s) {
            if ($s->id == $id) {
                unset($s);
            }
        }
    }
}
