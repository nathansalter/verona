<?php

namespace Verona\Value;

/**
 * Simple value to allow more explicit handling of arrays
 *
 * @author nathan
 *
 */
class ListValue implements \IteratorAggregate, \Countable
{
    /**
     *
     * @var array
     */
    protected $list;

    /**
     *
     * @param mixed ...$values
     */
    public function __construct(...$values)
    {
        $this->list = [];
        if (count($values) > 0) {
            $this->add(...$values);
        }
    }

    /**
     *
     * @param mixed ...$values
     * @return $this
     */
    public function add(...$values)
    {
        foreach ($values as $val) {
            $this->list[] = $val;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return array_values($this->list);
    }

    /**
     *
     * {@inheritDoc}
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getAll());
    }

    /**
     *
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * Returns true if this value contains the supplied value
     *
     * @param mixed $needle
     * @return bool
     */
    public function contains($needle) : bool
    {
        return in_array($needle, $this->getAll());
    }

    /**
     * Sort the list
     *
     * @param callable|null $callable
     * @return ListValue
     */
    public function sort(callable $callable = null) : ListValue
    {
        if (!$callable) {
            sort($this->list);
        } else {
            usort($this->list, $callable);
        }
        return $this;
    }

}