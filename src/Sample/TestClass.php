<?php

namespace Rozeo\Support\Sample;

use Rozeo\Support\Validator\ValidatableObject;

/**
 * Class TestClass
 * @package Rozeo\Support\Sample
 * @length(min=1, max=10)
 */
class TestClass implements TestClassInterface
{
    private $prop1;
    private $prop2;

    public function __construct()
    {
    }

    public function getName(): string
    {
        return 'test';
    }
}