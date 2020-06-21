<?php

namespace Mailery\Storage;

interface BucketInterface
{
    public function writeStream($filePath, $stream): File;
}
