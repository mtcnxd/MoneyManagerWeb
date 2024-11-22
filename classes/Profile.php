<?php

namespace classes;

class Profile 
{
    protected $username;

    protected function setProfile($username)
    {
        $this->username = $username;
    }

    protected function getProfile()
    {
        return $this->username;
    }
}