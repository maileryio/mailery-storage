<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Service;

use Mailery\Brand\Entity\Brand;
use Mailery\Storage\Repository\BucketRepository;
use Mailery\Storage\ValueObject\BucketValueObject;
use Mailery\Storage\Entity\Bucket;
use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;

class BucketService
{
    /**
     * @var ORMInterface
     */
    private ORMInterface $orm;

    /**
     * @param ORMInterface $orm
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param BucketValueObject $valueObject
     * @return Bucket
     */
    public function create(BucketValueObject $valueObject): Bucket
    {
        $bucket = (new Bucket())
            ->setBrand($valueObject->getBrand())
            ->setName($valueObject->getName())
            ->setTitle($valueObject->getTitle());

        $tr = new Transaction($this->orm);
        $tr->persist($bucket);
        $tr->run();

        return $bucket;
    }

    /**
     * @param BucketValueObject $valueObject
     * @return Bucket
     */
    public function getOrCreate(BucketValueObject $valueObject): Bucket
    {
        $bucketRepository = $this->getBucketRepository($valueObject->getBrand());

        if (($bucket = $bucketRepository->findByName($valueObject->getName())) === null) {
            $bucket = $this->create($valueObject);
        }

        return $bucket;
    }

    /**
     * @param Brand $brand
     * @return BucketRepository
     */
    private function getBucketRepository(Brand $brand): BucketRepository
    {
        return $this->orm->getRepository(Bucket::class)
            ->withBrand($brand);
    }
}
