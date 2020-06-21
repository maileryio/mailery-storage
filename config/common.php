<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Storage\BucketConfigs;

return [
    BucketConfigs::class => static function () use ($params) {
        return new BucketConfigs($params['maileryio/mailery-storage']['buckets']);
    },
];
