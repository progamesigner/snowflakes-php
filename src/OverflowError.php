<?php

namespace ProGameSigner\Snowflakes;

use Exception;

class OverflowError extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param int $current
     * @param int $last
     * @return void
     */
    public function __construct($value, $maximum)
    {
        parent::__construct(sprintf(
            'Invalid arguments supplied. %d is negative or larger than %d.',
            $value,
            $maximum
        ));
    }
}
