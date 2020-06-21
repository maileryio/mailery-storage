<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Mailery\Storage\Filesystem\FileStorageInterface;
use Mailery\Storage\Filesystem\RuntimeStorageInterface;

return [
    'aliases' => [
        '@storage' => '@root/storage',
    ],

    'cycle.common' => [
        'entityPaths' => [
            '@vendor/maileryio/mailery-storage/src/Entity',
        ],
    ],

    'file.storage' => [
        FileStorageInterface::class => [
            'adapter' => [
                '__class' => LocalFilesystemAdapter::class,
                '__construct()' => [
                    '@storage',
                    PortableVisibilityConverter::fromArray([
                        'file' => [
                            'public' => 0644,
                            'private' => 0600,
                        ],
                        'dir' => [
                            'public' => 0755,
                            'private' => 0700,
                        ],
                    ]),
                    LOCK_EX,
                    LocalFilesystemAdapter::DISALLOW_LINKS,
                ],
            ],
            'aliases' => [
                '@cache' => '@root/cache',
            ],
        ],
        RuntimeStorageInterface::class => [
            'adapter' => [
                '__class' => LocalFilesystemAdapter::class,
                '__construct()' => [
                    '@runtime',
                    PortableVisibilityConverter::fromArray([
                        'file' => [
                            'public' => 0644,
                            'private' => 0600,
                        ],
                        'dir' => [
                            'public' => 0755,
                            'private' => 0700,
                        ],
                    ]),
                    LOCK_EX,
                    LocalFilesystemAdapter::DISALLOW_LINKS,
                ],
            ],
            'aliases' => [
                '@cache' => '@root/cache',
            ],
        ],
    ],

    'maileryio/mailery-storage' => [
        'buckets' => [],
    ],
];
