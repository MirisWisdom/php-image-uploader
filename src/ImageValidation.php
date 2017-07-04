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

    /**
     * ImageValidation constructor.
     *
     * @param Image $image  Instance of the Image object
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Determines if the file extension for the file is valid.
     *
     * @return bool The extension is valid.
     */
    public function isExtensionValid() : bool
    {
        // Accepted extensions: JP(E)G and PNG
        return preg_match("/\.(jpe?g|png)\b/", $this->image->getRealName());
    }

    /**
     * Determines whether the file is bigger than the maximum size or not.
     *
     * @param   int $maxSize    The maximum size for the file.
     * @return  bool            File is not bigger than the maximum size.
     */
    public function isSizeValid(int $maxSize) : bool
    {
        return !$this->image->getFileSize() > $maxSize;
    }

    /**
     * Verifies that the file is an actual image file.
     *
     * @return bool The input file is an actual image.
     */
    public function isValidImage() : bool
    {
        return is_array(getimagesize($this->image->getTempName()));
    }

    /**
     * Verifies if the MIME type for the image is valid based on EXIF metadata.
     *
     * @return bool The MIME type is valid.
     */
    public function isValidType() : bool
    {
        $validMimes = array('image/jpeg', 'image/png');

        $hasImageType = exif_imagetype($this->image->getTempName());
        $hasValidMime = in_array(exif_imagetype($this->image->getTempName()), $validMimes);

        return $hasImageType && $hasValidMime;
    }
}