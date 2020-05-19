<?php

namespace Rozeo\Support\Validator;

interface RuleInterface
{
    public function parseArguments(string $argString): array;

    public function check($value, array $args): bool;
}