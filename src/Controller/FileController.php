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

use Mailery\Storage\Entity\File;
use Mailery\Storage\Repository\FileRepository;
use Mailery\Storage\WebController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FileController extends WebController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function download(Request $request): Response
    {
        $fileId = $request->getAttribute('id');
        if (empty($fileId) || ($file = $this->getFileRepository()->findByPK($fileId)) === null) {
            return $this->getResponseFactory()->createResponse(404);
        }

        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            // читаем файл и отправляем его пользователю
            if ($fd = fopen($file, 'rb')) {
                while (!feof($fd)) {
                    print fread($fd, 1024);
                }
                fclose($fd);
            }
            exit;
        }
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
