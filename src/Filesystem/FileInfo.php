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
     * @return resource
     */
    public function getStream()
    {
        return $this->getFilesystem()
            ->readStream($this->getLocation());
    }

    /**
     * @return int
     */
    public function getLineCount(): int
    {
        $lineCount = 0;
        $fileStream = $this->getStream();

        while (!feof($fileStream)) {
            if (($line = fgets($fileStream, 4096)) !== false) {
                $lineCount = $lineCount + substr_count($line, PHP_EOL);
            }
        }
        fclose($fileStream);

        return $lineCount;
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
