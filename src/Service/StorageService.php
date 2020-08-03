<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Service;

use Mailery\Storage\Entity\File;
use Mailery\Storage\Exception\FileAlreadyExistsException;
use Mailery\Storage\Provider\FilesystemProvider;
use Mailery\Storage\ValueObject\BucketValueObject;
use Mailery\Storage\ValueObject\FileValueObject;
use Mailery\Storage\Filesystem\FileInfo;

class StorageService
{
    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * @var BucketService
     */
    private BucketService $bucketService;

    /**
     * @var FilesystemProvider
     */
    private FilesystemProvider $filesystemProvider;

    /**
     * @param FileService $fileService
     * @param BucketService $bucketService
     * @param FilesystemProvider $filesystemProvider
     */
    public function __construct(FileService $fileService, BucketService $bucketService, FilesystemProvider $filesystemProvider)
    {
        $this->fileService = $fileService;
        $this->bucketService = $bucketService;
        $this->filesystemProvider = $filesystemProvider;
    }

    /**
     * @param FileValueObject $fileValueObject
     * @param BucketValueObject $bucketValueObject
     * @throws FileAlreadyExistsException
     * @return File
     */
    public function create(FileValueObject $fileValueObject, BucketValueObject $bucketValueObject): File
    {
        $location = $fileValueObject->getLocation();
        $filesystem = $this->filesystemProvider->getFilesystem($bucketValueObject->getFilesystem());

        if ($filesystem->fileExists($location)) {
            throw new FileAlreadyExistsException('File already exists with location "' . $location . '"');
        }

        $filesystem->write($location, $fileValueObject->getStream()->getContents());

        $bucket = $this->bucketService->getOrCreate($bucketValueObject);

        return $this->fileService->create(
            $fileValueObject->withBucket($bucket)
        );
    }

    /**
     * @param File $file
     * @return FileInfo
     */
    public function getFileInfo(File $file): FileInfo
    {
        return (new FileInfo($this->filesystemProvider))->withFile($file);
    }
}
