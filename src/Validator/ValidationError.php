<?php


namespace Rozeo\Support\Validator;


class ValidationError
{
    private $errors;

    public function hasError(): bool
    {
        return count($this->errors) > 0;
    }

    public function addError(string $name, string $key): self
    {
        $this->errors[$name][] = $key;
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorsByName(string $name): array
    {
        if (array_key_exists($name, $this->errors)) {
            return $this->errors[$name];
        }
        return [];
    }
}