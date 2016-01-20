<?php


namespace Verona\Value;

/**
 * This Class allows for an easy Enumerated Type class, by just defining constants in the header of the child classes
 *
 * Class AbstractEnumValue
 * @package Verona\Value
 */
class AbstractEnumValue
{

    /**
     * @var string
     */
    private $value;

    /**
     * AbstractEnumValue constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->set($value);
    }

    /**
     * Gets a list of the possible options
     *
     * @return array
     */
    public function getOptions() : array
    {
        $reflection = new \ReflectionClass(get_class($this));
        return array_values($reflection->getConstants());
    }

    /**
     * @param string $value
     * @return $this
     */
    public function set(string $value)
    {
        if (!in_array($value, $this->getOptions())) {
            throw new \InvalidArgumentException(sprintf('%s(%s) was not one of the permitted values: %s', __METHOD__, $value, implode(',', $this->getOptions())));
        }
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function get() : string
    {
        return $this->value;
    }

}