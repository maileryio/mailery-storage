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

use League\Flysystem\FilesystemAdapter;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Factory\Factory;
use Yiisoft\Yii\Filesystem\FileStorageConfigs;
use Yiisoft\Yii\Filesystem\Filesystem;

final class FileStorageServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $factory = new Factory();
        $aliases = $container->get(Aliases::class);
        $configs = $container->get(FileStorageConfigs::class)->getConfigs();

        foreach ($configs as $alias => $config) {
            $this->validateAdapter($alias, $config);

            // resolve alias
            $config['adapter']['__construct()'][0] = $aliases->get($config['adapter']['__construct()'][0]);

            $container->set(
                $alias,
                fn () => new Filesystem(
                    $factory->create($config['adapter']),
                    $config['aliases'] ?? [],
                    $config['config'] ?? []
                )
            );
        }
    }

    private function validateAdapter(string $alias, array $config): void
    {
        $adapter = $config['adapter']['__class'] ?? false;
        if (!$adapter) {
            throw new \RuntimeException("Adapter is not defined in the \"$alias\" storage config.");
        }

        if (!is_subclass_of($adapter, FilesystemAdapter::class)) {
            throw new \RuntimeException('Adapter must implement \League\Flysystem\FilesystemAdapter interface.');
        }
    }
}
