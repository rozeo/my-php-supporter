<?php

namespace Rozeo\Support\Validator;

class Validator
{
    const DEFAULT_RULES = [
        'type' => Rules\Type::class,
        'length' => Rules\StringLength::class,
    ];

    public function __construct($customs = [], $includeDefault = true)
    {
    }
}