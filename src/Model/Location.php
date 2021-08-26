<?php

namespace Mailery\Storage\Model;

use Mailery\Storage\LocationInterface;

class Location implements LocationInterface
{
    /**
     * @var string
     */
    private string $basePath;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * @param string $basePath
     * @param string $fileName
     */
    public function __construct(string $basePath, string $fileName)
    {
        $this->basePath = $basePath;
        $this->fileName = $fileName;
    }

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
