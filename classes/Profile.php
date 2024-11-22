<?php

namespace classes;

class Profile 
{
    protected $client;

    public __construct(Client $client)
    {
        $this->client = $client;
    }
}