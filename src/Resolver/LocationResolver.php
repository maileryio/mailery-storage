<?php

namespace Mailery\Storage\Resolver;

use Mailery\Storage\Model\Location;
use Mailery\Storage\LocationInterface;
use Mailery\Storage\Entity\File;
use Mailery\Storage\Model\BucketList;

class LocationResolver
{
    /**
     * @var BucketList
     */
    private BucketList $bucketList;

    /**
     * @param BucketList $bucketList
     */
    public function __construct(BucketList $bucketList)
    {
        $this->bucketList = $bucketList;
    }

    /**
     * @param File $file
     * @return LocationInterface
     */
    public function resolve(File $file): LocationInterface
    {
        $bucket = $this->bucketList->getByName($file->getBucket());

        return new Location(
            $bucket->getPath(),
            $file->getName()
        );
    }
}
