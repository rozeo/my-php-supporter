<?php

namespace Rozeo\Support\Validator;

class Rule implements RuleInterface
{
    public function parseArguments(string $argString): array
    {
        $args = [];
        foreach (explode(',', $argString) as $value) {
            $matched = preg_match(
                '/^([a-zA-Z]+)=?(.*)$/',
                trim($value),
                $match
            );

            if ($matched) {
                $args[$match[0]] = $match[1];
            }
        }
        return $args;
    }

    public function check($value, array $args): bool
    {
        foreach ($args as $name => $arg) {
            if (method_exists($this, $name)) {
                if (!$this->$name($value, $arg)) {
                    return false;
                }
            }
        }
        return true;
    }
}