<?php

namespace ProGameSigner\Snowflakes;

class Snowflake implements SnowflakeContract
{
    /**
     * The internal representation of Snowflake
     *
     * @var binary
     */
    protected $snowflake;

    /**
     * Create a new Snowflake instance.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     * @param int $w
     * @return void
     */
    public function __construct($x, $y, $z, $w)
    {
        $this->snowflake = pack('NNNN', $x, $y, $z, $w);
    }

    /**
     * Convert Snowflake to string representation.
     *
     * @return string
     */
    public function toString()
    {
        return bin2hex($this->snowflake);
    }

    /**
     * Convert Snowflake to binary representation.
     *
     * @return binary
     */
    public function toBinary()
    {
        return $this->snowflake;
    }
}
