<?php

namespace classes;

use classes\Client;

class Profile 
{
    protected $client;

    public __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getName()
    {
        $this->client;
        return "Hola mundo";
    }
}