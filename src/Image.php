<?php

/**
 * Class Image
 *
 * A class for storing image details according to the input $_FILE array.
 *
 * @author Roman Emilian <roman.emilian@outlook.com>
 */
class Image
{
    private $realName;
    private $tempName;
    private $fileSize;

    /**
     * Image constructor.
     *
     * @param array $image  $_FILE array storing the uploaded file information.
     */
    public function __construct(array $image)
    {
        $this->realName = $image['name'];
        $this->tempName = $image['tmp_name'];
        $this->fileSize = $image['size'];
    }

    /**
     * @return string   The name set by the end-user.
     */
    public function getRealName() : string
    {
        return $this->realName;
    }

    /**
     * @return string   Temporary name set by the server.
     */
    public function getTempName() : string
    {
        return $this->tempName;
    }

    /**
     * @return int  The file size of the file.
     */
    public function getFileSize() : int
    {
        return $this->fileSize;
    }
}