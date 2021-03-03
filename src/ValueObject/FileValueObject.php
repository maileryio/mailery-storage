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
use Mailery\Storage\Entity\Bucket;
use HttpSoft\Message\UploadedFile;
use Psr\Http\Message\StreamInterface;

class FileValueObject
{
    /**
     * @var Brand
     */
    private Brand $brand;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var Bucket
     */
    private Bucket $bucket;

    /**
     * @var StreamInterface
     */
    private StreamInterface $stream;

    /**
     * @param UploadedFile $uploadedFile
     * @return self
     */
    public static function fromUploadedFile(UploadedFile $uploadedFile): self
    {
        $new = new self();

        $new->name = $uploadedFile->getClientFilename() ?? 'Generated file name';
        $new->stream = $uploadedFile->getStream();

        return $new;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Bucket
     */
    public function getBucket(): Bucket
    {
        return $this->bucket;
    }

    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        return $this->stream;
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
     * @param Bucket $bucket
     * @return self
     */
    public function withBucket(Bucket $bucket): self
    {
        $new = clone $this;
        $new->bucket = $bucket;

        return $new;
    }
}
