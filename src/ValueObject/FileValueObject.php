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

use Mailery\Storage\Entity\Bucket;
use Mailery\Brand\Entity\Brand;
use Nyholm\Psr7\UploadedFile;
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
     * @var string
     */
    private string $location;

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

        $new->name = $uploadedFile->getClientFilename();
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
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
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

    /**
     * @param string $location
     * @return self
     */
    public function withLocation(string $location): self
    {
        $new = clone $this;
        $new->location = $location;

        return $new;
    }
}
