<?php

namespace Mailery\Storage\Generator;

use Mailery\Storage\Model\Location;
use Mailery\Storage\BucketInterface;
use Mailery\Storage\LocationInterface;
use Mailery\Storage\Exception\FileAlreadyExistsException;
use Ramsey\Uuid\Rfc4122\UuidV5;
use Symfony\Component\Mime\MimeTypes;
use Mailery\Storage\ValueObject\FileValueObject;

class LocationGenerator
{

    /**
     * @param MimeTypes $mimeTypes
     */
    public function __construct(
        private MimeTypes $mimeTypes
    ) {}

    /**
     * @param BucketInterface $bucket
     * @param FileValueObject $valueObject
     * @return LocationInterface
     */
    public function generate(BucketInterface $bucket, FileValueObject $valueObject): LocationInterface
    {
        $fnGenerator = function (BucketInterface $bucket, int $tryCount = 0) use(&$fnGenerator, $valueObject) {
            try {
                $location = new Location(
                    $bucket->getPath(),
                    $this->buildFileName($valueObject)
                );

                if ($bucket->getFilesystem()->fileExists((string) $location)) {
                    throw new FileAlreadyExistsException('File already exists with location "' . $location . '"');
                }

                return $location;
            } catch (FileAlreadyExistsException $e) {
                if ($tryCount === 5) {
                    throw $e;
                }

                return $fnGenerator($bucket, ++$tryCount);
            }
        };

        return $fnGenerator($bucket);
    }

    /**
     * @param FileValueObject $valueObject
     * @return string
     */
    private function buildFileName(FileValueObject $valueObject): string
    {
        $fileName = UuidV5::fromDateTime(new \DateTimeImmutable())->toString();
        $extensions = $this->mimeTypes->getExtensions($valueObject->getMimeType());

        $extension = $extensions[0] ?? null;
        if ($extension !== null) {
            $fileName = $fileName . '.' . $extension;
        }

        return $fileName;
    }
}
