<?php


namespace Rozeo\Support\Validator;


interface ValidatableObjectInterface
{
    public function getName(): string;

    public function value();
}