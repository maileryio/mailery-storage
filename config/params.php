<?php

declare(strict_types=1);

use Yiisoft\Definitions\DynamicReference;
use Mailery\Storage\Entity\File;

return [
    'yiisoft/aliases' => [
        'aliases' => [
            '@storage' => '@root/storage',
        ],
    ],

    'yiisoft/yii-cycle' => [
        'entity-paths' => [
            '@vendor/maileryio/mailery-storage/src/Entity',
        ],
    ],

    'maileryio/mailery-activity-log' => [
        'entity-groups' => [
            'storage' => [
                'label' => DynamicReference::to(static fn () => 'Storage'),
                'entities' => [
                    File::class,
                ],
            ],
        ],
    ],

    'maileryio/mailery-storage' => [
        'buckets' => [],
    ],
];
