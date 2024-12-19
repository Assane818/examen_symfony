<?php

namespace App\Enum;


enum Module: string
{
    case ALGO = 'Algo';
    case PYTHON = 'Python';
    case SYMFONY = 'Symfony';

    public static function getValue(int $id) : Module
    {
        return match ($id) {
            1 => Module::ALGO,
            2 => Module::PYTHON,
            3 => Module::SYMFONY,
        };
    }
}