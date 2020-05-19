<?php

namespace Rozeo\Support;

class Path
{
    const TRIM_MASK = "\t\n\r\0\x0B/";

    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $info = pathinfo(urldecode($path));

        $this->path = join(
            DIRECTORY_SEPARATOR,
            [
                preg_replace('/\.\.[\\\\\/]?/', '', $info['dirname']),
                $info['basename'],
            ]
        );

        $this->path = rtrim($this->path, self::TRIM_MASK);
    }

    public function join(string $path): Path
    {
        $path = ltrim($path, self::TRIM_MASK);

        return new Path(join(DIRECTORY_SEPARATOR, [
            $this->get(),
            $path,
        ]));
    }

    public function get(): string
    {
        return $this->path;
    }

    public function realpath(): string
    {
        return realpath($this->path) ?: '';
    }
}
