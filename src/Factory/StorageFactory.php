<?php

namespace Mailery\Storage\Factory;

use Yiisoft\Yii\Filesystem\FilesystemInterface;
use Mailery\Storage\Service\StorageService;
use Mailery\Storage\Service\FileService;
use Mailery\Storage\Service\BucketService;

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
