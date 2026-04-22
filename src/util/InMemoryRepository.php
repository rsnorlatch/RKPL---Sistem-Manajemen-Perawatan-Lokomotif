<?php

abstract class InMemoryRepository
{
    private mixed $data = [];

    public function count(): int
    {
        return count($this->data);
    }

    public function insert(int $id, string $username, string $email, string $password): void
    {
        $this->data[$id - 1] = new Driver($id, $username, $email, $password);
    }

    public function get(int $id)
    {
        return $this->data[$id - 1] ?? null;
    }

    public function getByUsername(string $username)
    {
        foreach ($this->data as $driver) {
            if ($driver->name === $username) {
                return $driver;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return array_values($this->data);
    }

    // TODO: replace every update function in every repository with the new implementation below
    public function update(int $id, string $username, string $email, string $password): void
    {
        if (isset($this->data[$id - 1])) {
            $this->data[$id - 1]->name = $username;
            $this->data[$id - 1]->email = $email;
            $this->data[$id - 1]->password = $password;
        } else {
            throw new Error("cannot find user with the id of $id");
        }
    }

    public function delete(int $id): void
    {
        unset($this->data[$id]);
    }
}
