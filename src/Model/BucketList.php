<?php

namespace Mailery\Storage\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Mailery\Storage\BucketInterface;

class BucketList extends ArrayCollection
{
    /**
     * @param BucketInterface[] $buckets
     */
    public function __construct(array $buckets = [])
    {
        parent::__construct($buckets);
    }

    /**
     * @param string $name
     * @return BucketInterface|null
     */
    public function getByName(string $name): ?BucketInterface
    {
        foreach ($this->toArray() as $bucket) {
            /** @var BucketInterface $bucket */
            if ($bucket->getName() === $name) {
                return $bucket;
            }
        }
        return null;
    }
}
