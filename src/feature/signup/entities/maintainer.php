<?php

namespace lms\feature\signup\entities;

class Maintainer
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct($id, $name, $email, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}