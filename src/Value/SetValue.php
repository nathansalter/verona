<?php

namespace Verona\Value;

/**
 * This is a very similar value to the list value but can only have one of each value
 * in it at a time
 *
 * @author Nathan Salter
 *
 */
class SetValue extends ListValue
{

    /**
     *
     * {@inheritDoc}
     * @see \Verona\Value\ListValue::add()
     */
    public function add(...$values)
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->getAll())) {
                parent::add($value);
            }
        }
        return $this;
    }

}