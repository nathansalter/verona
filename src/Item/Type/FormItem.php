<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;

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
     * @var array
     */
    private $values;

    public function __construct()
    {
        $this->assignId(self::ID_PREFIX);
        $this->definitions = [];
        $this->values = [];
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        if(! $this->hasName()) {
            throw new \RuntimeException(sprintf('%s() should have a name set, none set', __METHOD__));
        }
        return $this->name;
    }

    public function hasName() : bool
    {
        return $this->name !== null;
    }

    /**
     * @param string $name
     * @return FormItem
     */
    public function setName(string $name) : FormItem
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefinitions() : array
    {
        return $this->definitions;
    }

    /**
     * @param array $definitions
     * @return FormItem
     */
    public function setDefinitions(array $definitions) : FormItem
    {
        $this->definitions = $definitions;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues() : array
    {
        return $this->values;
    }

    /**
     * @param array $values
     * @return FormItem
     */
    public function setValues(array $values) : FormItem
    {
        $this->values = $values;
        return $this;
    }

    public function toArray() : array
    {
        return array_merge([
            self::EXCHANGE_NAME => $this->getName(),
            self::EXCHANGE_DEFINITIONS => $this->getDefinitions(),
            self::EXCHANGE_VALUES => $this->getValues()
        ], parent::toArray());
    }

    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if(isset($data[self::EXCHANGE_NAME])) {
            $this->setName($data[self::EXCHANGE_NAME]);
        }

        if(isset($data[self::EXCHANGE_DEFINITIONS])) {
            $this->setDefinitions($data[self::EXCHANGE_DEFINITIONS]);
        }

        if(isset($data[self::EXCHANGE_VALUES])) {
            $this->setValues($data[self::EXCHANGE_VALUES]);
        }

        return $this;

    }


}