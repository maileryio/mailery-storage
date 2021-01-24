<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Repository;

use Cycle\ORM\Select\Repository;
use Mailery\Brand\Entity\Brand;
use Yiisoft\Yii\Cycle\Data\Reader\EntityReader;
use Yiisoft\Data\Reader\DataReaderInterface;

class FileRepository extends Repository
{
    /**
     * @param array $scope
     * @param array $orderBy
     * @return DataReaderInterface
     */
    public function getDataReader(array $scope = [], array $orderBy = []): DataReaderInterface
    {
        return new EntityReader($this->select()->where($scope)->orderBy($orderBy));
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $repo = clone $this;
        $repo->select
            ->with('bucket')
            ->andWhere([
                'bucket.brand_id' => $brand->getId(),
            ]);

        return $repo;
    }
}
