<?php

namespace Rozeo\Support\Validator;

use Doctrine\Common\Annotations\AnnotationReader;
use Rozeo\Support\Validator\RuleInterface;
use Doctrine\Common\Annotations\SimpleAnnotationReader;

class Validator
{
    const DEFAULT_RULES = [
        'type' => Rules\Type::class,
        'length' => Rules\StringLength::class,
    ];

    /**
     * @var RuleInterface[]
     */

    private $rules;
    /**
     * @var AnnotationReader
     */
    private $reader;

    public function __construct($customs = [], $includeDefault = true)
    {
        $this->rules = [];

        $this->reader = new SimpleAnnotationReader();

        if ($includeDefault) {
            $this->rules = self::DEFAULT_RULES;
        }

        $diff = array_diff(
            array_keys($customs),
            array_keys($this->rules)
        );

        foreach ($diff as $name) {
            $this->rules[$name] = $customs[$name];
        }

        foreach ($this->rules as $name => $className) {
            $class = new $className;
            if (!($class instanceof RuleInterface)) {
                throw new \InvalidArgumentException(
                    "$className is not implements RuleInterface."
                );
            }
            $this->rules[$name] = $class;
        }
    }

    public function validate(ValidatableObject $value): bool
    {
        $errorObject = new ValidationError;

        $annotations = $this->getAnnotatedRules($value);

        var_dump($annotations);
        return false;
    }

    public function getAnnotatedRules(ValidatableObject $value): array
    {
        $reflection = new \ReflectionClass(get_class($value));
        var_dump(get_class($value));
        return $this->reader->getClassAnnotations($reflection);
    }
}