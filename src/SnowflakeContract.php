<?php

namespace ProGameSigner\Snowflakes;

interface SnowflakeContract
{
    /**
     * Convert Snowflake to string representation.
     *
     * @return string
     */
    public function toString();

    /**
     * Convert Snowflake to binary representation.
     *
     * @return binary
     */
    public function toBinary();
}
