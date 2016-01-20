<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;

class FormItem extends AbstractItem
{

    const ID_PREFIX = 'FRM:';

    const EXCHANGE_NAME = 'name';

    const EXCHANGE_DEFINITIONS = 'definitions';

    const EXCHANGE_VALUES = 'values';

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $definitions;

    /**
     * @var
     */
    private $values;

}