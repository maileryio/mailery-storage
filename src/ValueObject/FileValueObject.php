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
use HttpSoft\Message\UploadedFile;
use Psr\Http\Message\StreamInterface;
use Mailery\Storage\BucketInterface;
use Mailery\Storage\LocationInterface;

class FileValueObject
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $mimeType;

    /**
     * @var Brand
     */
    private Brand $brand;

    /**
     * @var BucketInterface
     */
    private BucketInterface $bucket;

    /**
     * @var LocationInterface
     */
    private LocationInterface $location;

    /**
     * @var StreamInterface
     */
    private StreamInterface $stream;

    /**
     * @param string $title
     * @param string $mimeType
     * @param StreamInterface $stream
     */
    public function __construct(
        string $title,
        string $mimeType,
        StreamInterface $stream
    ) {
        $this->title = $title;
        $this->mimeType = $mimeType;
        $this->stream = $stream;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return self
     */
    public static function fromUploadedFile(UploadedFile $uploadedFile): self
    {
        return new self(
            $uploadedFile->getClientFilename(),
            $uploadedFile->getClientMediaType(),
            $uploadedFile->getStream()
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @return BucketInterface
     */
    public function getBucket(): BucketInterface
    {
        return $this->bucket;
    }

    /**
     * @return LocationInterface
     */
    public function getLocation(): LocationInterface
    {
        return $this->location;
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
     * @param BucketInterface $bucket
     * @return self
     */
    public function withBucket(BucketInterface $bucket): self
    {
        $new = clone $this;
        $new->bucket = $bucket;

        return $new;
    }

    /**
     * @param LocationInterface $location
     * @return self
     */
    public function withLocation(LocationInterface $location): self
    {
        $new = clone $this;
        $new->location = $location;

        return $new;
    }
}
