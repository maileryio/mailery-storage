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
use Mailery\Storage\ValueObject\BucketValueObject;
use Mailery\Storage\ValueObject\FileValueObject;
use Yiisoft\Yii\Filesystem\FilesystemInterface;

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
     * @var FilesystemInterface
     */
    private FilesystemInterface $filesystem;

    /**
     * @param FileService $fileService
     * @param BucketService $bucketService
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FileService $fileService, BucketService $bucketService, FilesystemInterface $filesystem)
    {
        $this->fileService = $fileService;
        $this->bucketService = $bucketService;
        $this->filesystem = $filesystem;
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

        if ($this->filesystem->fileExists($location)) {
            throw new FileAlreadyExistsException('File already exists with location "' . $location . '"');
        }

        $this->filesystem->write($location, $fileValueObject->getStream()->getContents());

        $bucket = $this->bucketService->getOrCreate($bucketValueObject);

        return $this->fileService->create(
            $fileValueObject->withBucket($bucket)
        );
    }
}
