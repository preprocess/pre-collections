<?php

namespace Pre\Collections;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use Serializable;
use stdClass;

final class Collection implements ArrayAccess, Countable, IteratorAggregate, Serializable
{
    private $data = [];

    public function __construct($data = null)
    {
        if (is_object($data) && method_exists($data, "toArray")) {
            $data = $data->toArray();
        }

        if ($data instanceof Iterator) {
            $data = iterator_to_array($data);
        }

        if (is_object($data)) {
            $data = (array) $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $data[$key] = new self($value);
                }
            }
        }

        if (is_array($data)) {
          $this->data = $data;
        }
    }

    public function offsetSet($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function offsetGet($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    public function offsetExists($key)
    {
        return true;
    }

    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }

    public function __get($key)
    {
        return $this[$key];
    }

    public function __set($key, $value)
    {
        $this[$key] = $value;
    }

    public function __isset($key)
    {
        return true;
    }

    public function __unset($key)
    {
        unset($this[$key]);
    }

    public function toArray()
    {
        $array = [];

        foreach ($this->data as $key => $value) {
            if ($value instanceof self) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    public function serialize()
    {
        return serialize($this->data);
    }

    public function unserialize($serialized)
    {
        $this->data = unserialize($serialized);
    }

    public function without(...$keys)
    {
        if (count($keys) < 1) {
            throw new InvalidArgumentException("without called with no keys");
        }

        if (is_array($keys[0])) {
            $keys = $keys[0];
        }

        if (is_object($keys[0]) && method_exists($keys[0], "toArray")) {
            $keys = $keys[0]->toArray();
        }

        if ($keys[0] instanceof Iterator) {
            $keys = iterator_to_array($keys[0]);
        }

        $filtered = [];

        foreach ($this->data as $key => $value) {
            if (!in_array($key, $keys)) {
                $filtered[$key] = $value;
            }
        }

        return new self($filtered);
    }

    public function length()
    {
        return count($this);
    }

    public function with($key, $value)
    {
        $clone = clone($this);
        $clone[$key] = $value;

        return $clone;
    }

    public function map(Closure $map)
    {
        $mapped = [];

        foreach ($this->data as $key => $value) {
            $mapped[$key] = $map($value, $key);
        }

        return new self($mapped);
    }

    public function filter(Closure $filter)
    {
        $filtered = [];

        foreach ($this->data as $key => $value) {
            if ($filter($value, $key)) {
                $filtered[$key] = $value;
            }
        }

        return new self($filtered);
    }

    public function each(Closure $each)
    {
        foreach ($this->data as $key => $value) {
            $each($value, $key);
        }
    }

    public function reduce(Closure $reduce, $accumulator = null)
    {
        foreach ($this->data as $key => $value) {
            $accumulator = $reduce($accumulator, $value, $key);
        }

        return $accumulator;
    }

    public function merge(...$others)
    {
        $data = $this->data;

        foreach ($others as $other) {
            $collection = new self($other);
            $data = array_merge($data, $collection->toArray());
            $collection = null;
        }

        return new self($data);
    }

    public function join($glue = "")
    {
        return join($glue, $this->data);
    }

    public function keys()
    {
        return new self(array_keys($this->data));
    }

    public function values()
    {
        return new self(array_values($this->data));
    }

    public static function __set_state($exported)
    {
        return new static($exported["data"]);
    }
}
