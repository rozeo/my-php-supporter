<?php


namespace Rozeo\Support\Validator\Rules;

use Rozeo\Support\Validator\Rule;
use Rozeo\Support\Validator\RuleInterface;

/**
 * Class Type
 * @package Rozeo\Support\Validator\Rules
 * @Target()
 */
class Type extends Rule
{
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