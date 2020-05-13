<?php


namespace Rozeo\Support\Validator\Rules;

use Rozeo\Support\RuleInterface;
use rozeo\Support\Validator\DefaultRuleTrait;

class StringLength implements RuleInterface
{
    use DefaultRuleTrait;

    public function min(string $value, int $length): bool
    {
        return mb_strlen($value) >= $length;
    }

    public function max(string $value, int $length): bool
    {
        return mb_strlen($value) <= $length;
    }
}