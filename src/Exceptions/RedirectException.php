<?php

namespace Neurony\Redirects\Exceptions;

use Exception;

class RedirectException extends Exception
{
    /**
     * The exception to be thrown when the old url is the same as the new url.
     *
     * @return static
     */
    public static function sameUrls()
    {
        return new static('The old url cannot be the same as the new url!');
    }
}
