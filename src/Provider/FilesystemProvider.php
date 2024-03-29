<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Provider;

use Mailery\Storage\Entity\File;
use Mailery\Storage\Model\BucketList;
use Yiisoft\Yii\Filesystem\FilesystemInterface;

class FilesystemProvider
{
    /**
     * @param BucketList $bucketList
     */
    public function __construct(
        private BucketList $bucketList
    ) {}

    /**
     * @param File $file
     * @return FilesystemInterface FilesystemInterface
     */
    public function getFilesystem(File $file): FilesystemInterface
    {
        $bucket = $this->bucketList->getByName($file->getBucket());

        return $bucket->getFilesystem();
    }
}
