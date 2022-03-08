<?php

declare(strict_types=1);

/**
 * File storage module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-storage
 * @package   Mailery\Storage
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Storage\Controller;

use Mailery\Brand\BrandLocatorInterface as BrandLocator;
use Mailery\Storage\Service\StorageService;
use Mailery\Storage\Repository\FileRepository;
use Mailery\Storage\Filesystem\FileInfo;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ServerRequestInterface as Request;

class FileController
{
    /**
     * @var ResponseFactory
     */
    private ResponseFactory $responseFactory;

    /**
     * @var StorageService
     */
    private StorageService $storageService;

    /**
     * @var FileInfo
     */
    private FileInfo $fileInfo;

    /**
     * @var FileRepository
     */
    private FileRepository $fileRepository;

    /**
     * @param ResponseFactory $responseFactory
     * @param StorageService $storageService
     * @param FileInfo $fileInfo
     * @param FileRepository $fileRepository
     * @param BrandLocator $brandLocator
     */
    public function __construct(
        ResponseFactory $responseFactory,
        StorageService $storageService,
        FileInfo $fileInfo,
        FileRepository $fileRepository,
        BrandLocator $brandLocator
    ) {
        $this->responseFactory = $responseFactory;
        $this->storageService = $storageService;
        $this->fileInfo = $fileInfo;
        $this->fileRepository = $fileRepository
            ->withBrand($brandLocator->getBrand());
    }
    /**
     * @param Request $request
     */
    public function download(Request $request)
    {
        $fileId = $request->getAttribute('id');
        if (empty($fileId) || ($file = $this->fileRepository->findByPK($fileId)) === null) {
            return $this->responseFactory->createResponse(Status::NOT_FOUND);
        }

        $fileInfo = $this->fileInfo->withFile($file);
        if (!$fileInfo->fileExists()) {
            return $this->responseFactory->createResponse(Status::NOT_FOUND);
        }

        $stream = $fileInfo->getStream();

        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file->getTitle()));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $stream->getSize());

        while (!$stream->eof()) {
            print $stream->read(1024);
        }

        $stream->close();
    }
}
