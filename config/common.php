<?php

declare(strict_types=1);

use Mailery\Storage\Repository\FileRepository;
use Psr\Container\ContainerInterface;
use Cycle\ORM\ORMInterface;
use Mailery\Storage\Entity\File;

return [
    FileRepository::class => static function (ContainerInterface $container) {
        return $container
            ->get(ORMInterface::class)
            ->getRepository(File::class);
    },
];
