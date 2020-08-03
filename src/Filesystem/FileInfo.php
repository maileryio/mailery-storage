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
     * @param FilesystemProvider $filesystemProvider
     */
    public function __construct(FilesystemProvider $filesystemProvider)
    {
        $this->filesystemProvider = $filesystemProvider;
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
        return $this->filesystemProvider
            ->getFilesystem($this->file->getFilesystem())
            ->fileExists($this->file->getLocation());
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->filesystemProvider
            ->getFilesystem($this->file->getFilesystem())
            ->fileSize($this->file->getLocation());
    }

    /**
     * @return resource
     */
    public function getStream()
    {
        return $this->filesystemProvider
            ->getFilesystem($this->file->getFilesystem())
            ->readStream($this->file->getLocation());
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

}
