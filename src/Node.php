<?php

namespace ProGameSigner\Snowflakes;

class Node implements NodeContract
{
    const STEP_BITS = 16;
    const NODE_BITS = 48;
    const MASK_BITS = 32 - self::STEP_BITS;

    const ID_MASK = ~(PHP_INT_MAX << self::MASK_BITS);

    const MAX_STEPS = (1 << self::STEP_BITS);
    const MAX_NODES = (1 << self::NODE_BITS);

    /**
     * The node id.
     *
     * @var int
     */
    protected $id;

    /**
     * Last generated timestamp.
     *
     * @var int
     */
    protected $last;

    /**
     * Current step sequence.
     *
     * @var int
     */
    protected $step;

    /**
     * The EPOCH timestamp.
     *
     * @var int
     */
    protected $since;

    /**
     * Create a new Node instance.
     *
     * @param int $id
     * @param int $since
     * @return void
     */
    public function __construct(int $id, int $since = 0)
    {
        if (static::MAX_NODES > 0) {
            if ($id < 0 || $id > static::MAX_NODES) {
                throw new OverflowError($id, static::MAX_NODES);
            }
        } else {
            // @note: fallback for non 64-bit long native integer.
            if ($id < 0 || $id > PHP_INT_MAX) {
                throw new OverflowError($id, PHP_INT_MAX);
            }
        }

        $this->id = $id;
        $this->since = $since;

        $this->last = 0;
        $this->step = 0;
    }

    /**
     * Get next generated Snowflake instance.
     *
     * @return Snowflake
     */
    public function next()
    {
        $current = $this->timestamp();

        if ($current < $this->last) {
            throw new InvalidSystemClockError($current, $this->last);
        }

        if ($current === $this->last) {
            $this->step = ($this->step + 1) % static::MAX_STEPS;
            if ($this->step === 0) {
                // @note: we used out all bits of steps.
                $current = $this->waitUntilNextMillisecond($current);
            }
        } else {
            $this->step = 0;
        }

        $this->last = $current;


        return $this->generate(
            ($current >> 0x20) & 0x00000000FFFFFFFF,
            ($current >> 0x00) & 0x00000000FFFFFFFF,
            ($this->id >> static::STEP_BITS),
            (($this->id & static::ID_MASK) << static::MASK_BITS) + $this->step
        );
    }

    /**
     * Convert a binary representation to Snowflake.
     *
     * @return Snowflake
     */
    public function bin2snowflake($uuid)
    {
        return $this->generate(...unpack('N4', $uuid));
    }

    /**
     * Convert a hex string representation to Snowflake.
     *
     * @return Snowflake
     */
    public function hex2snowflake($uuid)
    {
        return $this->bin2snowflake(hex2bin($uuid));
    }

    /**
     * Get current timestamp.
     *
     * @return int
     */
    protected function timestamp()
    {
        return (int)(microtime(true) * 1000) - $this->since;
    }

    /**
     * Pause the execution until next millisecond.
     *
     * @return int
     */
    protected function waitUntilNextMillisecond($time)
    {
        $current = $time;

        while ($current < $time) {
            $current = $this->timestamp();
        }

        return $current;
    }

    /**
     * Generate a new Snowflake instance.
     *
     * @return Snowflake
     */
    protected function generate(... $args)
    {
        return new Snowflake(... $args);
    }
}
