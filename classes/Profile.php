<?php

namespace classes;

class Profile 
{
    protected $name;
    protected $age = 20;

    protected function setProfile($name)
    {
        $this->name = $name;
    }

    protected function getProfile()
    {
        return $this->name;
    }

    protected function setAge($age)
    {
        $this->age = $age;
    }

    protected function getAge()
    {
        return $this->age;
    }    
}