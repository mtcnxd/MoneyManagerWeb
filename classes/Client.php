<?php

namespace classes;

interface Client 
{
    public function setName(string $name): void;

    public function getName(): string;

    public function setAge(int $age);

    public function getAge();
}