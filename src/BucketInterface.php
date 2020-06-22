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

interface BucketInterface
{
    /**
     * @param string $location
     * @return bool
     */
    public function has(string $location): bool;

    /**
     * @param string $location
     * @param string $contents
     * @param array $config
     * @return void
     */
    public function write(string $location, string $contents, array $config = []): void;

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self;
}
