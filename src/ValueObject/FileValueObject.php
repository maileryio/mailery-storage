<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\ValueObject;

use Mailery\Brand\Entity\Brand;
use Mailery\Storage\BucketInterface;
use Nyholm\Psr7\UploadedFile;

class FileValueObject
{
    /**
     * @var Brand
     */
    private Brand $brand;

    /**
     * @var UploadedFile
     */
    private UploadedFile $uploadedFile;

    /**
     * @var BucketInterface
     */
    private BucketInterface $fileBucket;

    /**
     * @var string
     */
    private string $filePath;

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

    /**
     * @return BucketInterface
     */
    public function getFileBucket(): BucketInterface
    {
        return $this->fileBucket;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $new = clone $this;
        $new->brand = $brand;

        return $new;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return self
     */
    public function withUploadedFile(UploadedFile $uploadedFile): self
    {
        $new = clone $this;
        $new->uploadedFile = $uploadedFile;

        return $new;
    }

    /**
     * @param BucketInterface $fileBucket
     * @return self
     */
    public function withFileBucket(BucketInterface $fileBucket): self
    {
        $new = clone $this;
        $new->fileBucket = $fileBucket;

        return $new;
    }

    /**
     * @param string $filePath
     * @return self
     */
    public function withFilePath(string $filePath): self
    {
        $new = clone $this;
        $new->filePath = $filePath;

        return $new;
    }
}
