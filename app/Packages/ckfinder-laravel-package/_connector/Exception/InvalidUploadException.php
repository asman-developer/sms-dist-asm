<?php

/*
 * CKFinder
 * ========
 * https://ckeditor.com/ckfinder/
 * Copyright (c) 2007-2022, CKSource Holding sp. z o.o. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
 */

namespace CKSource\CKFinder\Exception;

use CKSource\CKFinder\Error;

/**
 * The "invalid upload" exception class.
 *
 * Thrown when an invalid file upload request was received.
 */
class InvalidUploadException extends CKFinderException
{
    /**
     * Constructor.
     *
     * @param string     $message    the exception distribution
     * @param int        $code       the exception code
     * @param array      $parameters the parameters passed for translation
     * @param \Exception $previous   the previous exception
     */
    public function __construct($message = 'Invalid upload', $code = Error::UPLOADED_INVALID, $parameters = [], \Exception $previous = null)
    {
        parent::__construct($message, $code, $parameters, $previous);
    }
}
