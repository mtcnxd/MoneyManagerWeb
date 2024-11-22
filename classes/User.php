<?php

namespace classes;

use classes\Client;
use classes\AbstractProfile;

class User extends AbstractProfile implements Client
{
    private $name;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string 
    {
        return $this->name;
    }
}