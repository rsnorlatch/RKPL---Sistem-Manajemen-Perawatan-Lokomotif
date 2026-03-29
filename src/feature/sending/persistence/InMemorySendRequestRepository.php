<?php

namespace lms\feature\sending\persistence;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\sending\entities\ISendRequestRepository;
use lms\feature\sending\entities\SendRequest;
use DateTime;

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

    public function insert(int $id, int $locomotive_id, int $destination_id, DateTime $request_time): void
    {
        array_push($this->_send_requests, new SendRequest($id, $locomotive_id, $destination_id, $request_time));
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

    public function update(int $id, int $locomotive_id, int $destination_id, DateTime $request_time): void
    {
        foreach ($this->_send_requests as $s) {
            if ($s->id == $id) {
                $s->locomotive_id = $locomotive_id;
                $s->destination_id = $destination_id;
                $s->request_time = $request_time;
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
