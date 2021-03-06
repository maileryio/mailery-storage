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

use Mailery\Storage\Entity\File;
use Mailery\Storage\Exception\FileAlreadyExistsException;
use Mailery\Storage\ValueObject\FileValueObject;
use Mailery\Storage\Generator\LocationGenerator;
use Mailery\Storage\Provider\FilesystemProvider;

class StorageService
{
    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * @var LocationGenerator
     */
    private LocationGenerator $locationGenerator;

    /**
     * @var FilesystemProvider
     */
    private FilesystemProvider $filesystemProvider;

    /**
     * @param FileService $fileService
     * @param LocationGenerator $locationGenerator
     * @param FilesystemProvider $filesystemProvider
     */
    public function __construct(
        FileService $fileService,
        LocationGenerator $locationGenerator,
        FilesystemProvider $filesystemProvider
    ) {
        $this->fileService = $fileService;
        $this->locationGenerator = $locationGenerator;
        $this->filesystemProvider = $filesystemProvider;
    }

    /**
     * @param FileValueObject $fileValueObject
     * @throws FileAlreadyExistsException
     * @return File
     */
    public function create(FileValueObject $fileValueObject): File
    {
        // TODO: need to use concurently strategy, e.g. mutex or lock file

        $bucket = $fileValueObject->getBucket();
        $location = $this->locationGenerator->generate($bucket, $fileValueObject);

        if ($bucket->getFilesystem()->fileExists((string) $location)) {
            throw new FileAlreadyExistsException('File already exists with location "' . $location . '"');
        }

        $bucket->getFilesystem()->write(
            (string) $location,
            $fileValueObject->getStream()->getContents()
        );

        return $this->fileService->create(
            $fileValueObject
                ->withLocation($location)
                ->withBucket($bucket)
        );
    }
}
