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

    /**
     * @return string
     */
    public function getRealName() : string
    {
        return $this->realName;
    }

    /**
     * @return string
     */
    public function getTempName() : string
    {
        return $this->tempName;
    }

    /**
     * @return int
     */
    public function getFileSize() : int
    {
        return $this->fileSize;
    }
}