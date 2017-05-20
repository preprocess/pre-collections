<?php

namespace Pre\Collections;

use ArrayIterator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Pre\Collections\Collection;

class CollectionTest extends TestCase
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

    /**
     * @test
     * @covers Pre\Collections\Collection::reduce
     */
    public function can_reduce_with_closure()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $result = $collection->reduce(function($value, $key, $accumulator) {
            return $accumulator + $value;
        });

        $expected = 6;

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::merge
     */
    public function can_merge_others()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $result = $collection->merge([
            "four" => 4,
        ], new Collection([
            "five" => 5,
        ]), new ArrayIterator([
            "six" => 6,
        ]), false /* not iterable */);

        $expected = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
            "four" => 4,
            "five" => 5,
            "six" => 6,
        ];

        $this->assertEquals($expected, $result->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::without
     */
    public function can_exclude_keys_with_without()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $expected = [
            "two" => 2,
            "three" => 3,
        ];

        $result = $collection->without("one");
        $this->assertEquals($expected, $result->toArray());

        $result = $collection->without(["one"]);
        $this->assertEquals($expected, $result->toArray());

        $result = $collection->without(new Collection(["one"]));
        $this->assertEquals($expected, $result->toArray());

        $result = $collection->without(new ArrayIterator(["one"]));
        $this->assertEquals($expected, $result->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::without
     */
    public function can_throw_with_no_without_keys()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Collection())->without();
    }
}
