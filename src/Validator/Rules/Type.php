<?php


namespace Rozeo\Support\Validator\Rules;


use Rozeo\Support\RuleInterface;
use rozeo\Support\Validator\DefaultRuleTrait;

class Type implements RuleInterface
{
    use DefaultRuleTrait;

    public function name($value, string $types): bool
    {

        $type = gettype($value);
        if ($type === 'object') {
            $type = get_class($value);
        }

        foreach (explode('|', $types) as $name) {
            if (trim($name) === $type) {
                return true;
            }
        }

        return false;
    }
}