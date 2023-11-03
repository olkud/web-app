<?php

namespace App\Domain\Formatters;

interface Formatter
{
    public function toArray(): array;
}