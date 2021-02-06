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
     * @var FileRepository
     */
    private FileRepository $fileRepository;

    /**
     * @param ResponseFactory $responseFactory
     * @param StorageService $storageService
     * @param FileRepository $fileRepository
     * @param BrandLocator $brandLocator
     */
    public function __construct(
        ResponseFactory $responseFactory,
        StorageService $storageService,
        FileRepository $fileRepository,
        BrandLocator $brandLocator
    ) {
        $this->responseFactory = $responseFactory;
        $this->storageService = $storageService;
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
            return $this->responseFactory->createResponse(404);
        }

        $fileInfo = $this->storageService->getFileInfo($file);

        if (!$fileInfo->fileExists()) {
            return $this->responseFactory->createResponse(404);
        }

        $fileStream = $fileInfo->getStream();
        $fileStat = fstat($fileStream);

        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file->getName()));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $fileStat['size']);

        while (!feof($fileStream)) {
            print fread($fileStream, 1024);
        }
        fclose($fileStream);
    }
}
