<?php

namespace App\Support;

class Path
{
    const TRIM_MASK = "\t\n\r\0\x0B/";

    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = realpath($path);
        $this->path = rtrim($this->path, self::TRIM_MASK);
    }

    public function join(string $path): Path
    {
        $path = ltrim($path, self::TRIM_MASK);

        return new Path(join(DIRECTORY_SEPARATOR, [
            $this->path,
            $path,
        ]));
    }

    public function get(): string
    {
        return $this->path;
    }
}