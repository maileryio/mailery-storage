<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage;

use Mailery\Brand\Entity\Brand;
use Yiisoft\Yii\Filesystem\FilesystemInterface as Filesystem;

class Bucket implements BucketInterface
{
    /**
     * @var Brand
     */
    private Brand $brand;

    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function write(string $location, string $contents, array $config = []): void
    {
        $this->filesystem->write($this->prefix($location), $contents, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function withBrand(Brand $brand): self
    {
        $new = clone $this;
        $new->brand = $brand;

        return $new;
    }

    /**
     * @param string $location
     * @throws \RuntimeException
     * @return string
     */
    private function prefix(string $location): string
    {
        if ($this->brand === null) {
            throw new \RuntimeException('Brand entity required');
        }

        return sprintf('/%s/%s', $this->brand->getId(), ltrim($location, '/'));
    }
}
