<?php

namespace Rozeo\Support;

interface RuleInterface
{
    public function parseArguments(string $argString): array;

    public function check($value, array $args): bool;
}