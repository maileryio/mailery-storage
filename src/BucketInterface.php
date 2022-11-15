<?php

namespace Mailery\Storage;

use Yiisoft\Yii\Filesystem\FilesystemInterface;
use Mailery\Brand\Entity\Brand;

interface BucketInterface
{

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return FilesystemInterface
     */
    public function getFilesystem(): FilesystemInterface;
}
