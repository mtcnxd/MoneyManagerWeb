<?php

namespace classes;

class Client 
{
    protected $name;
    protected $age = 20;

    public function setClient($name)
    {
        $this->name = $name;
    }

    public function getClient()
    {
        return $this->name;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getAge()
    {
        return $this->age;
    }    
}