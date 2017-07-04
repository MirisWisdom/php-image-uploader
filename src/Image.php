<?php

/**
 * Class Image
 *
 * A class for storing image data.
 *
 * @author Roman Emilian <roman.emilian@outlook.com>
 */
class Image
{
    private $realName;
    private $tempName;
    private $fileSize;

    public function __construct(array $image)
    {
        $this->realName = $image['name'];
        $this->tempName = $image['tmp_name'];
        $this->fileSize = $image['size'];
    }
}