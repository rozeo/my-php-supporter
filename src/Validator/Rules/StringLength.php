<?php


namespace Rozeo\Support\Validator\Rules;

use Rozeo\Support\Validator\Rule;
use Rozeo\Support\Validator\RuleInterface;

class StringLength extends Rule
{
    public function min(string $value, int $length): bool
    {
        return mb_strlen($value) >= $length;
    }

    public function max(string $value, int $length): bool
    {
        return mb_strlen($value) <= $length;
    }
}