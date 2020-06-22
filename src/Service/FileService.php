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

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Mailery\Storage\Entity\File;
use Mailery\Storage\ValueObject\FileValueObject;

class FileService
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
     * @param FileValueObject $valueObject
     * @return File
     */
    public function create(FileValueObject $valueObject): File
    {
        $fileBucket = $valueObject->getFileBucket()
            ->withBrand($valueObject->getBrand());

        if ($fileBucket->has($valueObject->getFilePath())) {
            throw new \RuntimeException('File already exists');
        }

        $fileBucket->write(
                $valueObject->getFilePath(),
                $valueObject->getUploadedFile()->getStream()->getContents()
            );

        $file = (new File())
            ->setBrand($valueObject->getBrand())
            ->setFilePath($valueObject->getFilePath())
        ;

        $tr = new Transaction($this->orm);
        $tr->persist($file);
        $tr->run();

        return $file;
    }

    /**
     * @param File $file
     * @param FileValueObject $valueObject
     * @return File
     */
    public function update(File $file, FileValueObject $valueObject): File
    {
        $file = $file
            ->setBrand($valueObject->getBrand())
        ;

        $tr = new Transaction($this->orm);
        $tr->persist($file);
        $tr->run();

        return $file;
    }

    /**
     * @param File $file
     * @return bool
     */
    public function delete(File $file): bool
    {
        $tr = new Transaction($this->orm);
        $tr->delete($file);
        $tr->run();

        return true;
    }
}
