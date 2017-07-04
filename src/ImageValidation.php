<?php
require_once 'ImageStatus.php';

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

    private $isExtensionValid;
    private $isSizeValid;
    private $isImageValid;
    private $isExifValid;
    private $isMimeValid;

    /**
     * ImageValidation constructor.
     *
     * @param Image $image  Instance of the Image object
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function getFileStatus()
    {
        if (is_null($this->isExtensionValid)) {
            $this->isExtensionValid();
        }

        if (is_null($this->isSizeValid)) {
            $this->isSizeValid();
        }

        return ($this->isExtensionValid && $this->isSizeValid)
            ? ImageStatus::ValidFile
            : ImageStatus::FileError;
    }

    public function getDataStatus()
    {
        if (is_null($this->isImageValid)) {
            $this->isImageValid();
        }

        if (is_null($this->isExifValid) || is_null($this->isMimeValid)) {
            $this->isTypeValid();
        }

        return ($this->isImageValid && $this->isExifValid && $this->isMimeValid)
            ? ImageStatus::ValidData
            : ImageStatus::DataError;
    }

    /**
     * Determines if the file extension for the file is valid.
     *
     * @return bool The extension is valid.
     */
    public function isExtensionValid() : bool
    {
        // Accepted extensions: JP(E)G and PNG
        $this->isExtensionValid = preg_match("/\.(jpe?g|png)\b/", $this->image->getRealName());
        return $this->isExtensionValid;
    }

    /**
     * Determines whether the file is bigger than the maximum size or not.
     *
     * @param   int $maxSize    The maximum size for the file.
     * @return  bool            File is not bigger than the maximum size.
     */
    public function isSizeValid(int $maxSize = 2 * ImageValidation::sizeMB) : bool
    {
        $this->isSizeValid = $this->image->getFileSize() < $maxSize;
        return $this->isSizeValid;
    }

    /**
     * Verifies that the file is an actual image file.
     *
     * @return bool The input file is an actual image.
     */
    public function isImageValid() : bool
    {
        $this->isImageValid = is_array(getimagesize($this->image->getTempName()));
        return $this->isImageValid;
    }

    /**
     * Verifies if the MIME type for the image is valid based on EXIF metadata.
     *
     * @return bool The MIME type is valid.
     */
    public function isTypeValid() : bool
    {
        $validMimes = array('image/jpeg', 'image/png');

        $this->isExifValid = exif_imagetype($this->image->getTempName());
        $this->isMimeValid = in_array(mime_content_type($this->image->getTempName()), $validMimes);

        return $this->isExifValid && $this->isMimeValid;
    }
}