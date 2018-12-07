<?php

namespace agilov\yii2testingkit;

use yii\test\FixtureTrait;

/**
 * Class FixtureGenerator
 *
 * Fixture generator helper to generate relational fixtures
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
class FixtureGenerator
{
    use FixtureTrait;

    /** @var FixtureGenerator */
    public static $instance;

    /** @var array */
    public $data = [];

    /** @var array */
    public $fixtures = [];

    /** @var \Closure */
    public $generate;

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return $this->fixtures;
    }

    public function __construct(callable $generate, array $fixtures = [])
    {
        $this->generate = $generate;
        $this->fixtures = $fixtures;
    }

    /**
     * @param callable $generate
     * @param array $fixtures
     */
    public static function generate(callable $generate, array $fixtures = [])
    {
        if (static::$instance === null) {
            static::$instance = new FixtureGenerator($generate, $fixtures);
            static::$instance->initFixtures();
            static::$instance->generate->call(static::$instance);
            static::$instance->unloadFixtures();
        }
    }

    /**
     * @return array
     */
    public static function shiftData()
    {
        return array_shift(static::$instance->data);
    }
}
