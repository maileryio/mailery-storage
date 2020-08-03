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

use Cycle\ORM\ORMInterface;
use Mailery\Brand\Service\BrandLocator;
use Mailery\Storage\Entity\File;
use Mailery\Storage\Service\StorageService;
use Mailery\Storage\Repository\FileRepository;
use Mailery\Storage\WebController;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Aliases\Aliases;
use Yiisoft\View\WebView;

class FileController extends WebController
{
    /**
     * @var StorageService
     */
    private StorageService $storageService;

    /**
     * @param BrandLocator $brandLocator
     * @param ResponseFactory $responseFactory
     * @param Aliases $aliases
     * @param WebView $view
     * @param ORMInterface $orm
     * @param StorageService $storageService
     */
    public function __construct(
        BrandLocator $brandLocator,
        ResponseFactory $responseFactory,
        Aliases $aliases,
        WebView $view,
        ORMInterface $orm,
        StorageService $storageService
    ) {
        $this->storageService = $storageService;
        parent::__construct($brandLocator, $responseFactory, $aliases, $view, $orm);
    }
    /**
     * @param Request $request
     */
    public function download(Request $request)
    {
        $fileId = $request->getAttribute('id');
        if (empty($fileId) || ($file = $this->getFileRepository()->findByPK($fileId)) === null) {
            return $this->getResponseFactory()->createResponse(404);
        }

        $fileInfo = $this->storageService->getFileInfo($file);

        if (!$fileInfo->fileExists()) {
            return $this->getResponseFactory()->createResponse(404);
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

    /**
     * @return FileRepository
     */
    private function getFileRepository(): FileRepository
    {
        return $this->getOrm()
            ->getRepository(File::class)
            ->withBrand($this->getBrandLocator()->getBrand());
    }
}
