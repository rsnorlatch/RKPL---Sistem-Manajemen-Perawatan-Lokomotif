<?php

namespace lms\feature\sending\persistence;

require_once __DIR__ . "/../../../../vendor/autoload.php";

use lms\feature\sending\entities\IStopRepository;
use lms\feature\sending\entities\Stop;

class InMemoryStopRepository implements IStopRepository
{
    private array $_stops;

    public function __construct(array $_stops)
    {
        $this->_stops = $_stops;
    }

    public function count(): int
    {
        return count($this->_stops);
    }

    public function insert(int $id, string $name, int $x, int $y): void
    {
        array_push($this->_stops, new Stop($id, $name, $x, $y));
    }

    public function get(int $id): Stop
    {
        return array_filter($this->_stops, function (Stop $s) use ($id) {
            return $s->id == $id;
        })[0];
    }

    public function getAll(): array
    {
        return $this->_stops;
    }

    public function update(int $id, string $name, int $x, int $y): void
    {
        foreach ($this->_stops as $s) {
            if ($s->id == $id) {
                $s->name = $name;
                $s->x = $x;
                $s->y = $y;
            }
        }
    }

    public function delete(int $id): void
    {
        foreach ($this->_stops as $s) {
            if ($s->id == $id) {
                unset($s);
            }
        }
    }
}
