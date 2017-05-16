<?php

namespace Pre\Collections;

use PHPUnit\Framework\TestCase;
use Pre\Collections\Collection;

class IterationTest extends TestCase
{
    /**
     * @test
     * @covers Pre\Collections\Collection::map
     */
    public function can_map_with_closure()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $result = $collection->map(function($value, $key) {
            return $value * 2;
        });

        $expected = [
            "one" => 2,
            "two" => 4,
            "three" => 6,
        ];

        $this->assertEquals($expected, $result->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::filter
     */
    public function can_filter_with_closure()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $result = $collection->filter(function($value, $key) {
            return $value === 1 || $key === "three";
        });

        $expected = [
            "one" => 1,
            "three" => 3,
        ];

        $this->assertEquals($expected, $result->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::each
     */
    public function can_each_with_closure()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $result = [];

        $collection->each(function($value, $key) use (&$result) {
            $result[] = "{$key} {$value}";
        });

        $expected = [
            "one 1",
            "two 2",
            "three 3",
        ];

        $this->assertEquals($expected, $result);
    }
}
