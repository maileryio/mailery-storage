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
     * @param UploadedFile $uploadedFile
     * @return self
     */
    public static function fromUploadedFile(UploadedFile $uploadedFile): self
    {
        $new = new self();
        $new->title = $uploadedFile->getClientFilename();
        $new->mimeType = $uploadedFile->getClientMediaType();
        $new->stream = $uploadedFile->getStream();

        return $new;
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
