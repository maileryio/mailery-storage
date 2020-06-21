<?php

declare(strict_types=1);

$params = $params['maileryio/mailery-storage'];

return [
    BucketConfigs::class => static function () use ($params) {
        return new BucketConfigs($params['buckets']);
    }
];
