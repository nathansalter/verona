<?php

namespace Verona\Value;

final class DateValue extends \DateTime
{

    /**
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct($value);
        $this->setTime(0, 0, 0);
    }

    /**
     *
     * @param \DateTime $dateTime
     * @return DateValue
     */
    public static function createFromDateTime(\DateTime $dateTime) : self
    {
        return new self($dateTime->format('Y-m-d'));
    }

}