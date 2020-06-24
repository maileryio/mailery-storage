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

use Yiisoft\Yii\Filesystem\FilesystemInterface;
use Mailery\Storage\Service\FileService;
use Mailery\Storage\Service\BucketService;
use Mailery\Storage\ValueObject\FileValueObject;
use Mailery\Storage\ValueObject\BucketValueObject;
use Mailery\Storage\Entity\File;

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
     */
    public function __construct(FileService $fileService, BucketService $bucketService, FilesystemInterface $filesystem)
    {
        $this->fileService = $fileService;
        $this->bucketService = $bucketService;
        $this->filesystem = $filesystem;
    }

    /**
     * @param FileValueObject $valueObject
     * @return File
     */
    public function create(FileValueObject $fileValueObject, BucketValueObject $bucketValueObject): File
    {
        $this->filesystem->write(
            $fileValueObject->getLocation(),
            $fileValueObject->getStream()->getContents()
        );

        $bucket = $this->bucketService->getOrCreate($bucketValueObject);

        return $this->fileService->create(
            $fileValueObject->withBucket($bucket)
        );
    }
}
