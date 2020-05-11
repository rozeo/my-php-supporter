<?php


namespace App\Support;


use Closure;
use InvalidArgumentException;
use ArrayAccess as ArrayAccessInterface;

class ArrayAccess implements ArrayAccessInterface
{
    const DELIMITER = '.';

    /**
     * @var array<mixed>
     */
    private $arr;

    /**
     * @var string
     */
    private $resolvedKey;

    public function __construct(array $arr = [])
    {
        foreach ($arr as $name => $value) {
            if (is_array($value)) {
                $this->arr[$name] = new ArrayAccess($value);
            } else {
                $this->arr[$name] = $value;
            }
        }
        $this->resolvedKey = '';
    }

    public function offsetExists($offset): bool
    {
        if (is_string($offset)) {
            return $this->offsetExists(explode(self::DELIMITER, $offset));
        } elseif (!is_array($offset)) {
            throw new InvalidArgumentException('Invalid offset type.');
        }

        $key = array_shift($offset);

        if (!array_key_exists($key, $this->arr)) {
            return false;
        }

        if (count($offset) === 0) {
            return true;
        }

        if ($this->arr[$key] instanceof ArrayAccessInterface) {
            return $this->arr[$key]->offsetExists($offset);
        } else {
            return false;
        }
    }

    public function offsetGet($offset)
    {
        if (is_string($offset)) {
            return $this->offsetGet(explode(self::DELIMITER, $offset));
        } elseif (!is_array($offset)) {
            throw new InvalidArgumentException('Invalid offset type.');
        }

        $key = array_shift($offset);

        if (!array_key_exists($key, $this->arr)) {
            throw new InvalidArgumentException('Undefined key in array.');
        }

        if (count($offset) === 0) {
            return $this->arr[$key];
        }

        if ($this->arr[$key] instanceof ArrayAccessInterface) {
            return $this->arr[$key]->offsetGet($offset);
        } else {
            return false;
        }
    }

    public function offsetSet($offset, $value): void
    {
        if (is_string($offset)) {
            $this->offsetSet(explode(self::DELIMITER, $offset), $value);
            return;
        } elseif (!is_array($offset)) {
            throw new InvalidArgumentException('Invalid offset type.');
        }

        $key = array_shift($offset);

        if (count($offset) === 0) {
            if (is_array($value)) {
                $this->arr[$key] = new ArrayAccess($value);
            } else {
                $this->arr[$key] = $value;
            }
            return;
        }

        if (!array_key_exists($key, $this->arr)) {
            $this->arr[$key] = new ArrayAccess;
        }

        if ($this->arr[$key] instanceof ArrayAccessInterface) {
            $this->arr[$key]->offsetSet($offset);
        } else {
            throw new InvalidArgumentException('Invalid offset.');
        }
    }

    public function offsetUnset($offset): void
    {
        if (is_string($offset)) {
            $this->offsetUnset(explode(self::DELIMITER, $offset));
            return;
        } elseif (!is_array($offset)) {
            throw new InvalidArgumentException('Invalid offset type.');
        }

        $key = array_shift($offset);

        if (!array_key_exists($key, $this->arr)) {
            return;
        }

        if (count($offset) === 0) {
            unset($this->arr[$key]);
            return;
        }

        if ($this->arr[$key] instanceof ArrayAccessInterface) {
            $this->arr[$key]->offsetUnset($offset);
        } else {
            throw new InvalidArgumentException('Invalid offset.');
        }
    }

    public function toArray(): array
    {
        return array_map(function ($value) {
            if ($value instanceof ArrayAccess) {
                return $value->get();
            }
            return $value;
        }, $this->arr);
    }

    /**
     * @var string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(string $name)
    {
        return $this->offsetGet(explode(self::DELIMITER, $name));
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function set(string $name, $value)
    {
        $this->offsetSet(explode(self::DELIMITER, $name), $value);
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists(string $name)
    {
        return $this->offsetExists(explode(self::DELIMITER, $name));
    }

    /**
     * @param string $name
     * @return $this
     */
    public function unset(string $name)
    {
        $this->offsetUnset(explode(self::DELIMITER, $name));
        return $this;
    }
}