<?php

namespace Mailery\Storage;

use Yiisoft\Yii\Filesystem\FilesystemInterface;

interface BucketInterface
{
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
