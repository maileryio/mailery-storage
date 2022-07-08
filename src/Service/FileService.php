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

use Cycle\ORM\EntityManagerInterface;
use Mailery\Storage\Entity\File;
use Mailery\Storage\ValueObject\FileValueObject;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;
use Mailery\Brand\Entity\Brand;

class FileService
{
    /**
     * @var Brand
     */
    private Brand $brand;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $new = clone $this;
        $new->brand = $brand;

        return $new;
    }

    /**
     * @param FileValueObject $valueObject
     * @return File
     */
    public function create(FileValueObject $valueObject): File
    {
        $file = (new File())
            ->setBrand($this->brand)
            ->setBucket($valueObject->getBucket()->getName())
            ->setName($valueObject->getLocation()->getFileName())
            ->setTitle($valueObject->getTitle())
            ->setMimeType($valueObject->getMimeType())
        ;

        (new EntityWriter($this->entityManager))->write([$file]);

        return $file;
    }
}
