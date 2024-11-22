<?php

namespace classes;

class Profile 
{
    protected $name;
    protected $age = 20;

    public function setProfile($name)
    {
        $this->name = $name;
    }

    public function getProfile()
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