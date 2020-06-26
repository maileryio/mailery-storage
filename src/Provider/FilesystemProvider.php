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

use Psr\Container\ContainerInterface as Container;
use Yiisoft\Yii\Filesystem\FilesystemInterface;

class FilesystemProvider
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @return FilesystemInterface FilesystemInterface
     */
    public function getFilesystem(string $name): FilesystemInterface
    {
        return $this->container->get($name);
    }
}
