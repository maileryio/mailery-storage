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
        $file = (new File())
            ->setBucket($valueObject->getBucket())
            ->setName($valueObject->getName())
            ->setLocation($valueObject->getLocation())
        ;

        $tr = new Transaction($this->orm);
        $tr->persist($file);
        $tr->run();

        return $file;
    }
}
