<?php

namespace ProGameSigner\Snowflakes;

interface NodeContract
{
    /**
     * Get next generated Snowflake instance.
     *
     * @return Snowflake
     */
    public function next();

    /**
     * Convert a binary representation to Snowflake.
     *
     * @return Snowflake
     */
    public function bin2snowflake($uuid);

    /**
     * Convert a hex string representation to Snowflake.
     *
     * @return Snowflake
     */
    public function hex2snowflake($uuid);
}
