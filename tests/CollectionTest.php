<?php

namespace Pre\Collections;

use ArrayIterator;
use InvalidArgumentException;
use Iterator;
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

        $result = $collection->reduce(function($accumulator, $value, $key) {
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
     * @covers Pre\Collections\Collection::merge
     */
    public function can_merge_arrays_with_numeric_keys()
    {
        $expected = ["one", "two", "three", "four", "five", "six"];

        $actual = (new Collection())
            ->merge(["one", "two", "three"])
            ->merge(["four", "five", "six"])
            ->toArray();

        $this->assertEquals($expected, $actual);
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

    /**
     * @test
     * @covers Pre\Collections\Collection::__get
     * @covers Pre\Collections\Collection::__set
     */
    public function can_get_and_set_values_with_arrows()
    {
        $collection = new Collection();

        $this->assertNull($collection->hello);

        $collection->hello = "world";

        $this->assertEquals("world", $collection->hello);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::offsetSet
     * @covers Pre\Collections\Collection::offsetGet
     */
    public function can_get_and_set_values_with_array_access()
    {
        $collection = new Collection();

        $this->assertNull($collection["hello"]);

        $collection["hello"] = "world";

        $this->assertEquals("world", $collection["hello"]);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::__isset
     * @covers Pre\Collections\Collection::offsetExists
     */
    public function can_always_show_isset()
    {
        $collection = new Collection();

        $this->assertTrue(isset($collection->hello));
        $this->assertNull($collection->hello);

        $this->assertTrue(isset($collection["hello"]));
        $this->assertNull($collection["hello"]);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::__unset
     */
    public function can_unset_with_arrows()
    {
        $collection = new Collection();
        $collection->hello = "world";

        $this->assertNotNull($collection->hello);

        unset($collection->hello);

        $this->assertNull($collection->hello);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::offsetUnset
     */
    public function can_unset_with_array_access()
    {
        $collection = new Collection();
        $collection["hello"] = "world";

        $this->assertNotNull($collection["hello"]);

        unset($collection["hello"]);

        $this->assertNull($collection["hello"]);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::toArray
     */
    public function can_convert_to_arrays()
    {
        $expected = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
            "nested" => [
                "five" => 5
            ]
        ];

        $collection = new Collection($expected);

        $this->assertEquals($expected, $collection->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::getIterator
     */
    public function can_get_iterators()
    {
        $expected = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ];

        $collection = new Collection($expected);

        $this->assertInstanceOf(Iterator::class, $collection->getIterator());
        $this->assertEquals($expected, iterator_to_array($collection));
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::count
     * @covers Pre\Collections\Collection::length
     */
    public function can_get_length()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $this->assertEquals(3, count($collection));
        $this->assertEquals(3, $collection->length());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::serialize
     * @covers Pre\Collections\Collection::unserialize
     */
    public function can_get_serialize_and_unserialize()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $expected = 'C:26:"Pre\Collections\Collection":50:{a:3:{s:3:"one";i:1;s:3:"two";i:2;s:5:"three";i:3;}}';
        $actual = serialize($collection);

        $this->assertEquals($expected, $actual);
        $this->assertEquals($collection, unserialize($actual));
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::with
     */
    public function can_add_values_using_with()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
        ]);

        $new = $collection->with("three", 3);

        $this->assertEquals(3, $new->three);
        $this->assertNotSame($collection, $new);
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::__construct
     */
    public function can_create_from_all_kinds_of_input()
    {
        $fromArray = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $fromObject = new Collection(
            json_decode('{"one":1,"two":2,"three":3}')
        );

        $fromCollection = new Collection(new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]));

        $fromIterator = new Collection(new ArrayIterator([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]));

        $expected = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ];

        $this->assertEquals($expected, $fromArray->toArray());
        $this->assertEquals($expected, $fromObject->toArray());
        $this->assertEquals($expected, $fromCollection->toArray());
        $this->assertEquals($expected, $fromIterator->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::join
     */
    public function can_join_values()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $expected1 = "123";
        $expected2 = "1,2,3";

        $this->assertEquals($expected1, $collection->join());
        $this->assertEquals($expected2, $collection->join(","));
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::keys
     */
    public function can_get_keys()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $expected = ["one", "two", "three"];

        $this->assertEquals($expected, $collection->keys()->toArray());
    }

    /**
     * @test
     * @covers Pre\Collections\Collection::values
     */
    public function can_get_values()
    {
        $collection = new Collection([
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ]);

        $expected = [1, 2, 3];

        $this->assertEquals($expected, $collection->values()->toArray());
    }
}
