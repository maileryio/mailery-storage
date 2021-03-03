<?php

namespace Mailery\Storage;

interface LocationInterface
{
    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return string
     */
    public function getFileName(): string;

    /**
     * @return string
     */
    public function getBasePath(): string;
}
