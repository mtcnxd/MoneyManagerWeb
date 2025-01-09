<?php

namespace classes;

interface Registry 
{
    public function setRegistrar(string $name): void;

    public function getRegistrar(): string;

    public function setHost(int $age);

    public function getHost();
}