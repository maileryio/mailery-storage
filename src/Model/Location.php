<?php

namespace Mailery\Storage\Model;

use Mailery\Storage\LocationInterface;

class Location implements LocationInterface
{
    /**
     * @param string $basePath
     * @param string $fileName
     */
    public function __construct(
        private string $basePath,
        private string $fileName
    ) {}

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . $this->getFileName();
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
