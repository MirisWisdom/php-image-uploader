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
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }
}