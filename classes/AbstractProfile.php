<?php

namespace classes;

use classes\Client;

class AbstractProfile implements Client
{
    private $name;
    protected $age;

    public function getName(): string 
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getAge()
    {

    }
}