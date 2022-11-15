<?php

namespace Mailery\Storage\Resolver;

use Mailery\Storage\Model\Location;
use Mailery\Storage\LocationInterface;
use Mailery\Storage\Entity\File;
use Mailery\Storage\Model\BucketList;

class LocationResolver
{
    /**
     * @param BucketList $bucketList
     */
    public function __construct(
        private BucketList $bucketList
    ) {}

    /**
     * @param File $file
     * @return LocationInterface
     */
    public function resolve(File $file): LocationInterface
    {
        $bucket = $this->bucketList->getByName($file->getBucket())
            ->withBrand($file->getBrand());

        return new Location(
            $bucket->getPath(),
            $file->getName()
        );
    }
}
