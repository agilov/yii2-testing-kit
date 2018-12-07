<?php

namespace agilov\yii2testingkit;

use PHPUnit\Framework\TestCase;

/**
 * Class FixtureGeneratorTest
 * vendor/bin/phpunit src/FixtureGeneratorTest
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
final class FixtureGeneratorTest extends TestCase
{
    /**
     * vendor/bin/phpunit --filter testGenerate src/FixtureGeneratorTest
     */
    public function testGenerate()
    {
        FixtureGenerator::generate(function () {
            /** @var FixtureGenerator $this  */
            $this->data[] = ['foo' => 'bar'];
        });

        $this->assertInstanceOf(FixtureGenerator::class, FixtureGenerator::$instance);
        $this->assertTrue(FixtureGenerator::$instance->data[0]['foo'] == 'bar');
        $this->assertTrue(FixtureGenerator::shiftData() == ['foo' => 'bar']);
        $this->assertTrue(count(FixtureGenerator::$instance->data) == 0);
    }
}
