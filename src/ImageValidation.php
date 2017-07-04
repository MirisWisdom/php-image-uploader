<?php

/**
 * Class ImageValidation
 *
 * A class for validating images based on GitHugop's business rules.
 *
 * @author Roman Emilian <roman.emilian@outlook.com>
 */
class ImageValidation
{
    public const sizeKB = 1024;
    public const sizeMB = 1048576;
    public const sizeGB = 1073741824;

    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function isExtensionValid() : bool
    {
        return preg_match("/\.(jpe?g|png)\b/", $this->image->getRealName());
    }

    public function isSizeValid(int $maxSize) : bool
    {
        return !$this->image->getFileSize() > $maxSize;
    }

    public function isValidImage() : bool
    {
        return is_array(getimagesize($this->image->getTempName()));
    }

    public function isValidType() : bool
    {
        $validMimes = array('image/jpeg', 'image/png');

        $hasImageType = exif_imagetype($this->image->getTempName());
        $hasValidMime = in_array(exif_imagetype($this->image->getTempName()), $validMimes);

        return $hasImageType && $hasValidMime;
    }
}