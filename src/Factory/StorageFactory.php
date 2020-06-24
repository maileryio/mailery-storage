<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Factory;

use Mailery\Storage\Service\BucketService;
use Mailery\Storage\Service\FileService;
use Mailery\Storage\Service\StorageService;
use Yiisoft\Yii\Filesystem\FilesystemInterface;

class StorageFactory
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
    public function __construct(FileService $fileService, BucketService $bucketService)
    {
        $this->fileService = $fileService;
        $this->bucketService = $bucketService;
    }

    /**
     * @return StorageService
     */
    public function create(): StorageService
    {
        return new StorageService(
            $this->fileService,
            $this->bucketService,
            $this->filesystem
        );
    }

    /**
     * @param FilesystemInterface $filesystem
     * @return self
     */
    public function withFilesystem(FilesystemInterface $filesystem): self
    {
        $new = clone $this;
        $new->filesystem = $filesystem;

        return $new;
    }
}
