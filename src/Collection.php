<?php

namespace Pre\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Serializable;
use stdClass;

final class Collection implements ArrayAccess, Countable, IteratorAggregate, Serializable
{
    private $data = [];

    public function __construct($data = null)
    {
        if ($data instanceof self) {
            $this->data = $data->toArray();
        }

        if ($data instanceof stdClass) {
            $this->data = (array) $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $this->data[$key] = new static($value);
                } else {
                    $this->data[$key] = $value;
                }
            }
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
            if ($value instanceof static) {
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
        $this->data = unserialize($serialised);
    }

    public function without(...$keys)
    {
        if (count($keys) === 1 && is_array($keys[0])) {
            $keys = $keys[0];
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
}
