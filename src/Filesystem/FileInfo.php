<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Filesystem;

use Mailery\Storage\Entity\File;
use Mailery\Storage\Provider\FilesystemProvider;
use Mailery\Storage\Resolver\LocationResolver;
use Yiisoft\Yii\Filesystem\FilesystemInterface;
use HttpSoft\Message\Stream;
use Psr\Http\Message\StreamInterface;

class FileInfo
{

    /**
     * @var File
     */
    private File $file;

    /**
     * @var FilesystemProvider
     */
    private FilesystemProvider $filesystemProvider;

    /**
     * @var LocationResolver
     */
    private LocationResolver $locationResolver;

    /**
     * @param FilesystemProvider $filesystemProvider
     * @param LocationResolver $locationResolver
     */
    public function __construct(
        FilesystemProvider $filesystemProvider,
        LocationResolver $locationResolver
    ) {
        $this->filesystemProvider = $filesystemProvider;
        $this->locationResolver = $locationResolver;
    }

    /**
     * @param File $file
     * @return \self
     */
    public function withFile(File $file): self
    {
        $new = clone $this;
        $new->file = $file;

        return $new;
    }

    /**
     * @return bool
     */
    public function fileExists(): bool
    {
        return $this->getFilesystem()
            ->fileExists($this->getLocation());
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->getFilesystem()
            ->fileSize($this->getLocation());
    }

    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        $resource = $this->getFilesystem()->readStream($this->getLocation());
        return new Stream($resource);
    }

    /**
     * @return FilesystemInterface
     */
    private function getFilesystem(): FilesystemInterface
    {
        return $this->filesystemProvider->getFilesystem($this->file);
    }

    /**
     * @return string
     */
    private function getLocation(): string
    {
        return (string) $this->locationResolver->resolve($this->file);
    }
}
