<?php

namespace ProGameSigner\Snowflakes;

use Exception;

class InvalidSystemClockError extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param int $current
     * @param int $last
     * @return void
     */
    public function __construct($current, $last)
    {
        parent::__construct(sprintf(
            'Clock moved backwards. Refusing to generate id at %d milliseconds',
            $current
        ));
    }
}
