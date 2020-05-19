<?php


namespace Rozeo\Support\Validator;


abstract class ValidatableObject implements ValidatableObjectInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}