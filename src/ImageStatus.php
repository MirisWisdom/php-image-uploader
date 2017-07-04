<?php

/**
 * Class ImageStatus
 *
 * An enumerator for the image status.
 *
 * Data status should be used for the file contents' validity.
 * File status should be used for the file container's validity.
 *
 * @author Roman Emilian <roman.emilian@outlook.com>
 */
abstract class ImageStatus
{
    public const
        FileError = 0,
        DataError = 1,
        ValidFile = 2,
        ValidData = 3;
}