<?php

namespace Mailery\Storage\Provider;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Storage\Controller\FileController;

final class RouteCollectorServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addGroup(
            Group::create('/brand/{brandId:\d+}')
                ->routes(
                    Route::get('/storage/file/download/{id:\d+}')
                        ->name('/storage/file/download')
                        ->action([FileController::class, 'download'])
            )
        );
    }
}
